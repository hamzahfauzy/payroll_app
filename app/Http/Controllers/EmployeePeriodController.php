<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Sallary;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\EmployeePeriod;
use App\Models\EmployeeSallary;

/**
 * Class EmployeePeriodController
 * @package App\Http\Controllers
 */
class EmployeePeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $period = isset($_GET['period'])?$_GET['period']:0;
        $periods = Period::get()->pluck('name','id');
        if($period)
        {
            // generate record by period
            $employees = Employee::get();
            foreach($employees as $employee)
            {
                $check = EmployeePeriod::where('period_id',$period)->where('employee_id',$employee->id)->exists();
                if(!$check)
                    EmployeePeriod::create([
                        'employee_id' => $employee->id,
                        'period_id'   => $period,
                        'status'      => 'Belum Dibayar'
                    ]);
                
            }
        }

        $employeePeriods = EmployeePeriod::where('period_id',$period)->paginate();

        return view('employee-period.index', compact('employeePeriods','period','periods'))
            ->with('i', (request()->input('page', 1) - 1) * $employeePeriods->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employeePeriod = new EmployeePeriod();
        return view('employee-period.create', compact('employeePeriod'));
    }

    public function sallaryPanel(Request $request, EmployeePeriod $employeePeriod)
    {
        if($request->method() == 'POST')
        {
            $refs = Sallary::get();
            foreach($refs as $ref)
            {
                $check = EmployeeSallary::where('period_id',$employeePeriod->period_id)
                                        ->where('employee_id',$employeePeriod->employee_id)
                                        ->where('sallary_id',$ref->id);
                if($check->exists())
                {
                    $check->first()->update([
                        'amount' => $request->sallary[$ref->id]
                    ]);
                }
                else
                    EmployeeSallary::create([
                        'period_id' => $employeePeriod->period_id,
                        'employee_id' => $employeePeriod->employee_id,
                        'sallary_id' => $ref->id,
                        'amount' => $request->sallary[$ref->id]
                    ]);

            }
            return redirect()->route('employee-periods.index',['period'=>$employeePeriod->period_id])
                ->with('success', 'Gaji Karyawan '.$employeePeriod->employee->name.' berhasil diupdate');
        }
        $refs = Sallary::get();
        foreach($refs as $ref)
        {
            $check = EmployeeSallary::where('period_id',$employeePeriod->period_id)
                                    ->where('employee_id',$employeePeriod->employee_id)
                                    ->where('sallary_id',$ref->id)->exists();
            if(!$check)
                EmployeeSallary::create([
                    'period_id' => $employeePeriod->period_id,
                    'employee_id' => $employeePeriod->employee_id,
                    'sallary_id' => $ref->id,
                    'amount' => 0,
                ]);
        }

        // sallary group
        $sallaries = EmployeeSallary::where('period_id',$employeePeriod->period_id)
                                    ->where('employee_id',$employeePeriod->employee_id)->get();

        $bonus = [];
        $potongan = [];
        foreach($sallaries as $sallary)
        {
            if($sallary->sallary->sallary_type=='Bonus')
                $bonus[] = $sallary;
            else
                $potongan[] = $sallary;
        }

        return view('employee-period.sallary-panel', compact('employeePeriod','bonus','potongan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(EmployeePeriod::$rules);

        $employeePeriod = EmployeePeriod::create($request->all());

        return redirect()->route('employee-periods.index')
            ->with('success', 'EmployeePeriod created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employeePeriod = EmployeePeriod::find($id);

        return view('employee-period.show', compact('employeePeriod'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employeePeriod = EmployeePeriod::find($id);

        return view('employee-period.edit', compact('employeePeriod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  EmployeePeriod $employeePeriod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeePeriod $employeePeriod)
    {
        request()->validate(EmployeePeriod::$rules);

        $employeePeriod->update($request->all());

        return redirect()->route('employee-periods.index')
            ->with('success', 'EmployeePeriod updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $employeePeriod = EmployeePeriod::find($id)->delete();

        return redirect()->route('employee-periods.index')
            ->with('success', 'EmployeePeriod deleted successfully');
    }
}
