<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Allowance;
use Illuminate\Http\Request;

/**
 * Class AllowanceController
 * @package App\Http\Controllers
 */
class AllowanceController extends Controller
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
        $allowances = Allowance::paginate();

        return view('allowance.index', compact('allowances'))
            ->with('i', (request()->input('page', 1) - 1) * $allowances->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allowance = new Allowance();
        $positions = $this->position->get()->pluck('name','id');
        return view('allowance.create', compact('allowance','positions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Allowance::$rules);

        $allowance = Allowance::create($request->all());

        return redirect()->route('allowances.index')
            ->with('success', 'Allowance created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $allowance = Allowance::find($id);

        return view('allowance.show', compact('allowance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $allowance = Allowance::find($id);
        $positions = $this->position->get()->pluck('name','id');

        return view('allowance.edit', compact('allowance','positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Allowance $allowance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Allowance $allowance)
    {
        request()->validate(Allowance::$rules);

        $allowance->update($request->all());

        return redirect()->route('allowances.index')
            ->with('success', 'Allowance updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $allowance = Allowance::find($id)->delete();

        return redirect()->route('allowances.index')
            ->with('success', 'Allowance deleted successfully');
    }
}
