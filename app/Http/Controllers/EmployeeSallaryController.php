<?php

namespace App\Http\Controllers;

use App\Models\EmployeeSallary;
use Illuminate\Http\Request;

/**
 * Class EmployeeSallaryController
 * @package App\Http\Controllers
 */
class EmployeeSallaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employeeSallaries = EmployeeSallary::paginate();

        return view('employee-sallary.index', compact('employeeSallaries'))
            ->with('i', (request()->input('page', 1) - 1) * $employeeSallaries->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employeeSallary = new EmployeeSallary();
        return view('employee-sallary.create', compact('employeeSallary'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(EmployeeSallary::$rules);

        $employeeSallary = EmployeeSallary::create($request->all());

        return redirect()->route('employee-sallaries.index')
            ->with('success', 'EmployeeSallary created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employeeSallary = EmployeeSallary::find($id);

        return view('employee-sallary.show', compact('employeeSallary'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employeeSallary = EmployeeSallary::find($id);

        return view('employee-sallary.edit', compact('employeeSallary'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  EmployeeSallary $employeeSallary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeSallary $employeeSallary)
    {
        request()->validate(EmployeeSallary::$rules);

        $employeeSallary->update($request->all());

        return redirect()->route('employee-sallaries.index')
            ->with('success', 'EmployeeSallary updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $employeeSallary = EmployeeSallary::find($id)->delete();

        return redirect()->route('employee-sallaries.index')
            ->with('success', 'EmployeeSallary deleted successfully');
    }
}
