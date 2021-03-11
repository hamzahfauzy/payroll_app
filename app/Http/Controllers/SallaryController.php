<?php

namespace App\Http\Controllers;

use App\Models\Sallary;
use Illuminate\Http\Request;

/**
 * Class SallaryController
 * @package App\Http\Controllers
 */
class SallaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sallaries = Sallary::paginate();

        return view('sallary.index', compact('sallaries'))
            ->with('i', (request()->input('page', 1) - 1) * $sallaries->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sallary = new Sallary();
        return view('sallary.create', compact('sallary'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Sallary::$rules);

        $sallary = Sallary::create($request->all());

        return redirect()->route('sallaries.index')
            ->with('success', 'Sallary created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sallary = Sallary::find($id);

        return view('sallary.show', compact('sallary'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sallary = Sallary::find($id);

        return view('sallary.edit', compact('sallary'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Sallary $sallary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sallary $sallary)
    {
        request()->validate(Sallary::$rules);

        $sallary->update($request->all());

        return redirect()->route('sallaries.index')
            ->with('success', 'Sallary updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $sallary = Sallary::find($id)->delete();

        return redirect()->route('sallaries.index')
            ->with('success', 'Sallary deleted successfully');
    }
}
