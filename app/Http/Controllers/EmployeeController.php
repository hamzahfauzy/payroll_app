<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class EmployeeController
 * @package App\Http\Controllers
 */
class EmployeeController extends Controller
{
    function __construct()
    {
        $this->position = new Position;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::paginate();

        return view('employee.index', compact('employees'))
            ->with('i', (request()->input('page', 1) - 1) * $employees->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee = new Employee();
        $positions = $this->position->get()->pluck('name','id');
        return view('employee.create', compact('employee','positions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = Employee::$rules;
        $rules['password'] = 'required';
        request()->validate($rules);

        DB::beginTransaction();
        try {
            //code...
            $user = User::create([
                'name' => $request->name,
                'email' => $request->NIK,
                'password' => $request->password,
            ]);
            $data = $request->all();
            $data['user_id'] = $user->id;
            $employee = Employee::create($data);
            DB::commit();
            return redirect()->route('employees.index')
            ->with('success', 'Berhasil buat karyawan.');
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollback();
            return redirect()->back()->withInput();
        }

        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);

        return view('employee.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        $positions = $this->position->get()->pluck('name','id');

        return view('employee.edit', compact('employee','positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $rules = Employee::$rules;
        $rules['NIK'] = $rules['NIK'] . ',id,' . $employee->id;
        request()->validate($rules);
        DB::beginTransaction();
        try {
            //code...
            if($request->password)
                $employee->user->update(['password'=>$request->password]);

            $employee->user->update([
                'name' => $request->name,
                'email' => $request->NIK
            ]);

            $employee->update($request->all());
            DB::commit();
            return redirect()->route('employees.index')
            ->with('success', 'Berhasil update karyawan.');
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollback();
            return redirect()->back()->withInput();
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        Employee::find($id)->user->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully');
    }
}
