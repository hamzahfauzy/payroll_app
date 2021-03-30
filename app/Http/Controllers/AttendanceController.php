<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

/**
 * Class AttendanceController
 * @package App\Http\Controllers
 */
class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = Attendance::paginate();

        return view('attendance.index', compact('attendances'))
            ->with('i', (request()->input('page', 1) - 1) * $attendances->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attendance = new Attendance();
        return view('attendance.create', compact('attendance'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Attendance::$rules);

        $attendance = Attendance::create($request->all());

        return redirect()->route('attendances.index')
            ->with('success', 'Attendance created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $attendance = Attendance::find($id);

        return view('attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attendance = Attendance::find($id);

        return view('attendance.edit', compact('attendance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Attendance $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        request()->validate(Attendance::$rules);

        $attendance->update($request->all());

        return redirect()->route('attendances.index')
            ->with('success', 'Attendance updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $attendance = Attendance::find($id)->delete();

        return redirect()->route('attendances.index')
            ->with('success', 'Attendance deleted successfully');
    }
}
