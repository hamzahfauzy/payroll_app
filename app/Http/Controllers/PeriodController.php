<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

/**
 * Class PeriodController
 * @package App\Http\Controllers
 */
class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periods = Period::paginate();

        return view('period.index', compact('periods'))
            ->with('i', (request()->input('page', 1) - 1) * $periods->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $period = new Period();
        return view('period.create', compact('period'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Period::$rules);

        $period = Period::create($request->all());

        return redirect()->route('periods.index')
            ->with('success', 'Period created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $period = Period::find($id);

        return view('period.show', compact('period'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $period = Period::find($id);

        return view('period.edit', compact('period'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Period $period
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Period $period)
    {
        request()->validate(Period::$rules);

        $period->update($request->all());

        return redirect()->route('periods.index')
            ->with('success', 'Period updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $period = Period::find($id)->delete();

        return redirect()->route('periods.index')
            ->with('success', 'Period deleted successfully');
    }
}
