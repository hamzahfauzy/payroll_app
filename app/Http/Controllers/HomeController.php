<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\User;
use App\Models\Period;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Installation;
use Illuminate\Http\Request;
use App\Models\EmployeePeriod;
use App\Models\EmployeeSallary;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->installation = Installation::first();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $installation = $this->installation;

        $user = Auth::user();

        if ($user->employee) {
            $employeePeriods = $user->employee->employeePeriods;

            return view('home', compact('employeePeriods'));
        }

        $employee = Employee::get()->count();
        $period = Period::get()->count();
        $position = Position::get()->count();
        $not_paid = EmployeePeriod::where('status', 'Belum Dibayar')->get()->count();

        return view('home', compact('employee', 'period', 'position', 'not_paid'));
    }

    function payroll(EmployeePeriod $employeePeriod)
    {
        $user = $employeePeriod->employee->user;

        $employeeSallaries = EmployeeSallary::where('period_id', $employeePeriod->period_id)->where('employee_id', $employeePeriod->employee_id)->get();

        $data = [];

        foreach ($employeeSallaries as $employeeSallary) {
            if ($employeeSallary->sallary->sallary_type == "Bonus") {
                $data["pendapatan"][$employeeSallary->sallary->name] = $employeeSallary->amount;
            } else {
                $data["potongan"][$employeeSallary->sallary->name] = $employeeSallary->amount;
            }
        }

        $data["pendapatan"]['Gaji Pokok'] = $user->employee->position->sallary;
        $data["pendapatan"]["Tunjangan"] = $user->employee->tunjangan;
        $data["potongan"]['Biaya Jabatan'] = $user->employee->position->cost;

        $total = $employeePeriod->sallary_total;

        $installation = $this->installation;
        $title = 'SLIP-'.$user->employee->NIK.'-'.$employeePeriod->period->name;
        $logo = public_path().Storage::url($installation->logo);
        $type = pathinfo($logo, PATHINFO_EXTENSION);
        $logo = file_get_contents($logo);
        $logo = 'data:image/' . $type . ';base64,' . base64_encode($logo);
        // $logo = Storage::get($installation->logo);

        // return $logo;

        // return view('payroll', compact('employeePeriod', 'user', 'data', 'total', 'installation','title','logo'));

        $dompdf = new Dompdf();
        $dompdf->setPaper('Folio','portrait');
        $dompdf->loadHtml(view('payroll', compact('employeePeriod', 'user', 'data', 'total', 'installation','title','logo')));
        $dompdf->render();
        $dompdf->stream($title.'.pdf',array("Attachment" => false));
    }

    public function edit_profile(Request $request)
    {

        if ($request->isMethod("post")) {

            $user = User::find(Auth::id());

            if ($user->employee == null) {

                $request->validate([
                    'name' => 'required|string',
                    'email' =>
                    [
                        'required',
                        'string',
                        Rule::unique('users')->ignore($user->id),
                    ],
                    'password' => 'nullable|string|confirmed',

                    'company_name' => 'required',
                    'phone_number' => 'required',
                    'address' => 'required',
                    'company_email' => 'required',
                    'postal_code' => 'required',
                    'logo' => 'nullable|file|max:500',
                ]);

                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = $request->password ?? $user->password;

                $logo = $request->file('logo') ? $request->file('logo')->store('public/logo') : $this->installation->logo;

                $install = $this->installation->update([
                    'company_name' => $request->company_name,
                    'email' => $request->company_email,
                    'phone_number' => $request->phone_number,
                    'address' => $request->address,
                    'postal_code' => $request->postal_code,
                    'logo' => $logo
                ]);

                if ($user->save() && $install) {
                    return redirect()->back()->with("success", "Edit profile & installation success");
                }
            } else {

                $request->validate([
                    'name' => 'required|string',
                    'email' =>
                    [
                        'required',
                        'string',
                        Rule::unique('users')->ignore($user->id),
                    ],
                    'password' => 'nullable|string|confirmed',

                    'NIK' =>
                    [
                        'required',
                        'string',
                        Rule::unique('employees')->ignore($user->employee->id),
                    ],
                    'NPWP' =>
                    [
                        'required',
                        'string',
                        Rule::unique('employees')->ignore($user->employee->id),
                    ],
                    'employee_name' => 'required|string',
                    'work_around' => 'required|string',
                    'bank_account' => 'required|string',
                ]);

                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = $request->password ?? $user->password;

                $employee = $user->employee->update([
                    'name' => $request->employee_name,
                    'NIK' => $request->NIK,
                    'NPWP' => $request->NPWP,
                    'work_around' => $request->work_around,
                    'bank_account' => $request->bank_account,
                ]);

                if ($user->save() && $employee) {
                    return redirect()->back()->with("success", "Edit profile & employee success");
                }
            }
        }

        $installation = $this->installation;

        return view('edit-profile', compact('installation'));
    }

    public function installation(Request $request)
    {
        if ($request->method() == 'POST') {
            $request->validate([
                'company_name' => 'required',
                'phone_number' => 'required',
                'address' => 'required',
                'company_email' => 'required',
                'postal_code' => 'required',
                'email' => 'required',
                'password' => 'required',
                'logo' => 'required|file|max:500',
            ]);
            $logo = $request->file('logo')->store('public/logo');
            Installation::create([
                'company_name' => $request->company_name,
                'email' => $request->company_email,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'postal_code' => $request->postal_code,
                'logo' => $logo,
            ]);

            User::create([
                'name' => $request->company_name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return redirect()->route('home');
        }
        return view('installation');
    }
}
