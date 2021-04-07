<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\User;
use App\Models\Period;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Installation;
use Illuminate\Http\Request;
use App\Models\EmployeePeriod;
use App\Models\EmployeeSallary;
use Illuminate\Validation\Rule;
use LaravelQRCode\Facades\QRCode;
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
        $installation = $this->installation;
        $title = 'SLIP-'.$employeePeriod->employee->NIK.'-'.$employeePeriod->period->name;
        $logo = public_path().Storage::url($installation->logo);
        $type = pathinfo($logo, PATHINFO_EXTENSION);
        $logo = file_get_contents($logo);
        $logo = 'data:image/' . $type . ';base64,' . base64_encode($logo);

        QRCode::text(route('payroll',$employeePeriod->id))->setOutfile(public_path().'/qrcode/'.$title.'.png')->png();

        $qrcode = public_path().'/qrcode/'.$title.'.png';
        $type = pathinfo($qrcode, PATHINFO_EXTENSION);
        $data = file_get_contents($qrcode);
        $qrcode = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $options = new Options(); 
        $options->set('isPhpEnabled', 'true'); 
        
        $dompdf = new Dompdf($options);
        $dompdf->setPaper('Folio','portrait');
        $dompdf->loadHtml(view('payroll', compact('employeePeriod','installation','title','logo','qrcode')));
        $dompdf->render();

        $canvas = $dompdf->getCanvas(); 
 
        // Get height and width of page 
        $w = $canvas->get_width(); 
        $h = $canvas->get_height(); 
        
        // Specify watermark image 
        $imageURL = public_path().Storage::url($installation->slip_watermark); 
        $imgWidth = 400; 
        $imgHeight = 400; 
        
        // Set image opacity 
        $canvas->set_opacity(.15); 
        
        // Specify horizontal and vertical position 
        $x = (($w-$imgWidth)/2); 
        $y = (($h-$imgHeight)/2); 
        
        // Add an image to the pdf 
        $canvas->image($imageURL, $x, $y, $imgWidth, $imgHeight); 

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
                    'slip_watermark' => 'nullable|file|max:500',
                ]);

                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);

                if($request->password)
                    $user->update(['password'=>$request->password]);

                $logo = $request->file('logo') ? $request->file('logo')->store('public/logo') : $this->installation->logo;
                $slip_watermark = $request->file('slip_watermark') ? $request->file('slip_watermark')->store('public/slip_watermark') : $this->installation->slip_watermark;

                $install = $this->installation->update([
                    'company_name' => $request->company_name,
                    'email' => $request->company_email,
                    'phone_number' => $request->phone_number,
                    'address' => $request->address,
                    'postal_code' => $request->postal_code,
                    'logo' => $logo,
                    'slip_watermark' => $slip_watermark,
                ]);

                if ($install) {
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

                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);

                if($request->password)
                    $user->update(['password'=>$request->password]);

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
                'slip_watermark' => 'required|file|max:500',
            ]);
            $logo = $request->file('logo')->store('public/logo');
            $slip_watermark = $request->file('slip_watermark')->store('public/slip_watermark');
            Installation::create([
                'company_name' => $request->company_name,
                'email' => $request->company_email,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'postal_code' => $request->postal_code,
                'logo' => $logo,
                'slip_watermark' => $slip_watermark,
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
