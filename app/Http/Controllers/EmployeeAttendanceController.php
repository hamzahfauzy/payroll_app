<?php

namespace App\Http\Controllers;

use App\Models\EmployeeAttendance;
use Illuminate\Http\Request;

/**
 * Class EmployeeAttendanceController
 * @package App\Http\Controllers
 */
class EmployeeAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employeeAttendances = EmployeeAttendance::paginate();

        return view('employee-attendance.index', compact('employeeAttendances'))
            ->with('i', (request()->input('page', 1) - 1) * $employeeAttendances->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employeeAttendance = new EmployeeAttendance();
        return view('employee-attendance.create', compact('employeeAttendance'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(EmployeeAttendance::$rules);

        $employeeAttendance = EmployeeAttendance::create($request->all());

        return redirect()->route('employee-attendances.index')
            ->with('success', 'EmployeeAttendance created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employeeAttendance = EmployeeAttendance::find($id);

        return view('employee-attendance.show', compact('employeeAttendance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employeeAttendance = EmployeeAttendance::find($id);

        return view('employee-attendance.edit', compact('employeeAttendance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  EmployeeAttendance $employeeAttendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeAttendance $employeeAttendance)
    {
        request()->validate(EmployeeAttendance::$rules);

        $employeeAttendance->update($request->all());

        return redirect()->route('employee-attendances.index')
            ->with('success', 'EmployeeAttendance updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $employeeAttendance = EmployeeAttendance::find($id)->delete();

        return redirect()->route('employee-attendances.index')
            ->with('success', 'EmployeeAttendance deleted successfully');
    }
}
