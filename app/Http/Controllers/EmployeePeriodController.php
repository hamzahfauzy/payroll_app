<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Period;
use App\Models\Sallary;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Installation;
use Illuminate\Http\Request;
use App\Models\EmployeePeriod;
use App\Models\EmployeeSallary;
use LaravelQRCode\Facades\QRCode;
use App\Models\EmployeeAttendance;
use Illuminate\Support\Facades\DB;

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
        $period = isset($_GET['period']) ? $_GET['period'] : 0;
        $periods = Period::get()->pluck('name', 'id');
        if ($period) {
            // generate record by period
            $employees = Employee::get();
            foreach ($employees as $employee) {
                $check = EmployeePeriod::where('period_id', $period)->where('employee_id', $employee->id)->exists();
                if (!$check)
                    EmployeePeriod::create([
                        'employee_id' => $employee->id,
                        'period_id'   => $period,
                        'status'      => 'Belum Dibayar'
                    ]);
            }
        }

        $employeePeriods = EmployeePeriod::where('period_id', $period)->paginate();
        $employeePeriods->appends(['period'=>$period]);

        return view('employee-period.index', compact('employeePeriods', 'period', 'periods'))
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
        if ($request->method() == 'POST') {
            $refs = Sallary::get();
            foreach ($refs as $ref) {
                $check = EmployeeSallary::where('period_id', $employeePeriod->period_id)
                    ->where('employee_id', $employeePeriod->employee_id)
                    ->where('sallary_id', $ref->id);
                if ($check->exists()) {
                    $check->first()->update([
                        'amount' => $request->sallary[$ref->id]
                    ]);
                } else
                    EmployeeSallary::create([
                        'period_id' => $employeePeriod->period_id,
                        'employee_id' => $employeePeriod->employee_id,
                        'sallary_id' => $ref->id,
                        'amount' => $request->sallary[$ref->id]
                    ]);
            }

            $refs_attendance = Attendance::get();
            foreach($refs_attendance as $ref)
            {
                $check = EmployeeAttendance::where('period_id', $employeePeriod->period_id)
                ->where('employee_id', $employeePeriod->employee_id)
                ->where('attendance_id', $ref->id);
                if ($check->exists()) {
                    $check->first()->update([
                        'amount' => $request->attendance[$ref->id]
                    ]);
                } else
                    EmployeeAttendance::create([
                        'period_id' => $employeePeriod->period_id,
                        'employee_id' => $employeePeriod->employee_id,
                        'attendance_id' => $ref->id,
                        'amount' => $request->attendance[$ref->id]
                    ]);
            }
            return redirect()->route('employee-periods.index', ['period' => $employeePeriod->period_id])
                ->with('success', 'Gaji Karyawan ' . $employeePeriod->employee->name . ' berhasil diupdate');
        }
        $refs = Sallary::get();
        foreach ($refs as $ref) {
            $check = EmployeeSallary::where('period_id', $employeePeriod->period_id)
                ->where('employee_id', $employeePeriod->employee_id)
                ->where('sallary_id', $ref->id)->exists();
            if (!$check)
                EmployeeSallary::create([
                    'period_id' => $employeePeriod->period_id,
                    'employee_id' => $employeePeriod->employee_id,
                    'sallary_id' => $ref->id,
                    'amount' => 0,
                ]);
        }

        $refs = Attendance::get();
        foreach ($refs as $ref) {
            $check = EmployeeAttendance::where('period_id', $employeePeriod->period_id)
                ->where('employee_id', $employeePeriod->employee_id)
                ->where('attendance_id', $ref->id)->exists();
            if (!$check)
                EmployeeAttendance::create([
                    'period_id' => $employeePeriod->period_id,
                    'employee_id' => $employeePeriod->employee_id,
                    'attendance_id' => $ref->id,
                    'amount' => 0,
                ]);
        }

        // sallary group
        $sallaries = EmployeeSallary::where('period_id', $employeePeriod->period_id)
            ->where('employee_id', $employeePeriod->employee_id)->get();

        $absensi = EmployeeAttendance::where('period_id', $employeePeriod->period_id)
        ->where('employee_id', $employeePeriod->employee_id)->get();

        $bonus = [];
        $potongan = [];
        foreach ($sallaries as $sallary) {
            if ($sallary->sallary->sallary_type == 'Bonus')
                $bonus[] = $sallary;
            else
                $potongan[] = $sallary;
        }

        return view('employee-period.sallary-panel', compact('employeePeriod', 'bonus', 'potongan','absensi'));
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

    public function pay(EmployeePeriod $employeePeriod)
    {
        $employeePeriod->update([
            'status' => 'Sudah Dibayar',
            'payout_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->route('employee-periods.index',['period'=>$employeePeriod->period_id])
            ->with('success', 'Payout updated successfully');
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

    public function import(Request $request)
    {
        if ($request->isMethod("post"))
        {
            $request->validate([
                'period' => 'required',
                'file'   => 'required'
            ]);
            $file = $request->file('file');
            $extension = $file->extension();
            if($extension=='xlsx'){
                $inputFileType = 'Xlsx';
            }else{
                $inputFileType = 'Xls';
            }
            $reader     = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
             
            $spreadsheet = $reader->load($file);
            $worksheet   = $spreadsheet->getActiveSheet();
            $highestRow  = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

            $attendances = new Attendance;
            $bonus       = Sallary::where('sallary_type','Bonus');
            $potongan    = Sallary::where('sallary_type','Potongan');

            DB::beginTransaction();
            try {
                //code...
                $absensi_start = 4;
                $absensi_end   = $absensi_start + $attendances->count();
                $bonus_start   = $absensi_end;
                $bonus_end     = $bonus_start + $bonus->count();
                $potongan_start = $bonus_end;
                $potongan_end  = $potongan_start + $potongan->count();

                $attendances = $attendances->get();
                $bonus       = $bonus->get();
                $potongan    = $potongan->get();
                for ($row = 2; $row <= $highestRow; $row++) { //$row = 2 artinya baris kedua yang dibaca dulu(header kolom diskip disesuaikan saja)
                    $employee = Employee::where('NIK',$worksheet->getCellByColumnAndRow(2, $row)->getValue())->first();
                    EmployeeAttendance::where('employee_id',$employee->id)
                        ->where('period_id',$request->period)
                        ->delete();

                    EmployeeSallary::where('employee_id',$employee->id)
                        ->where('period_id',$request->period)
                        ->delete();
                    $absensis = [];
                    for($i=$absensi_start;$i<$absensi_end;$i++)
                    {
                        $index = $i-$absensi_start;
                        $absensis[] = [
                            'attendance_id' => $attendances[$index]->id,
                            'period_id' => $request->period,
                            'employee_id' => $employee->id,
                            'amount' => $worksheet->getCellByColumnAndRow($i, $row)->getValue()
                        ];
                    }
                    EmployeeAttendance::insert($absensis);

                    $sallary_bonus = [];
                    for($i=$bonus_start;$i<$bonus_end;$i++)
                    {
                        $index = $i-$bonus_start;
                        $sallary_bonus[] = [
                            'sallary_id' => $bonus[$index]->id,
                            'period_id' => $request->period,
                            'employee_id' => $employee->id,
                            'amount' => $worksheet->getCellByColumnAndRow($i, $row)->getValue()
                        ];
                    }
                    EmployeeSallary::insert($sallary_bonus);

                    $sallary_potongan = [];
                    for($i=$potongan_start;$i<$potongan_end;$i++)
                    {
                        $index = $i-$potongan_start;
                        $sallary_potongan[] = [
                            'sallary_id' => $potongan[$index]->id,
                            'period_id' => $request->period,
                            'employee_id' => $employee->id,
                            'amount' => $worksheet->getCellByColumnAndRow($i, $row)->getValue()
                        ];
                    }
                    EmployeeSallary::insert($sallary_potongan);
                }
                DB::commit();
                return redirect()->route('employee-periods.index',['period'=>$request->period])
                    ->with('success', 'Employee Sallary imported successfully');
            } catch (\Throwable $th) {
                DB::rollback();
                // return redirect()->route('emloyees.index')
                //     ->with('error', 'Position imported failed');
                throw $th;
            }
        }
        $periods = Period::get()->pluck('name', 'id');
        return view('employee-period.import',compact('periods'));
    }

    public function download()
    {
        $employees   = Employee::get();
        $attendances = Attendance::get();
        $bonus       = Sallary::where('sallary_type','Bonus')->get();
        $potongan    = Sallary::where('sallary_type','Potongan')->get();

        $employees_row = "";
        foreach($employees as $key => $employee)
        {
            $employees_row .= "<tr><td>".($key+1)."</td><td>".$employee->NIK."</td><td>".$employee->name."</td>";
            foreach($attendances as $attendance)
                $employees_row .= "<td></td>";
            foreach($bonus as $value)
                $employees_row .= "<td></td>";
            foreach($potongan as $value)
                $employees_row .= "<td></td>";
            $employees_row .= "</tr>";
        }

        $html = "
        <table>
            <tr>
                <td>No</td>
                <td>NIK</td>
                <td>NAMA</td>";
        foreach($attendances as $attendance)
            $html .= "<td>$attendance->name</td>";
        foreach($bonus as $value)
            $html .= "<td>$value->name</td>";
        foreach($potongan as $value)
            $html .= "<td>$value->name</td>";
        $html .= "
            </tr>
            $employees_row
        </table>
        ";

        $filename = 'format-import/import-'.date('Y-m-d').'.xls';

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        $spreadsheet = $reader->loadFromString($html);

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save($filename); 

        return redirect($filename);

    }

    public function bulkdownload(Request $request)
    {
        if($request->action == 'terpilih')
            $employeePeriods = EmployeePeriod::whereIn('id',$request->download)->get();
        elseif($request->action == 'semua')
            $employeePeriods = EmployeePeriod::where('period_id',$request->period)->get();
        $installation = Installation::first();
        $logo = public_path().\Storage::url($installation->logo);
        $type = pathinfo($logo, PATHINFO_EXTENSION);
        $logo = file_get_contents($logo);
        $logo = 'data:image/' . $type . ';base64,' . base64_encode($logo);

        $report = "
        <style>
            h3,p {
                margin:0;
                padding:0;
            }

            hr {
                margin: 12px 0;
            }

            body {
                padding: 24px;
                font-size:12px;
            }

            table {
                width: 100%;
            }

            .p6 {
                padding:3px;
            }

            #ttd {
                margin-top: 12px;
            }

            .right {
                text-align: right;
            }

            .t-right {
                text-align: right;
            }
            #watermark {
                position: absolute;
                top: 45%;
                width: 100%;
                text-align: center;
                opacity: .15;
                transform: rotate(10deg);
                transform-origin: 50% 50%;
                z-index: -1000;
            }
            .page_break { page-break-after: always; }
            .page_break:last-child { page-break-after: avoid; }
        </style>
        ";
        foreach($employeePeriods as $employeePeriod)
        {
            $title = 'SLIP-'.$employeePeriod->employee->NIK.'-'.$employeePeriod->period->name;
            QRCode::text(route('payroll',$employeePeriod->id))->setOutfile(public_path().'/qrcode/'.$title.'.png')->png();
            $qrcode = public_path().'/qrcode/'.$title.'.png';
            $type = pathinfo($qrcode, PATHINFO_EXTENSION);
            $data = file_get_contents($qrcode);
            $qrcode = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $wm = public_path().\Storage::url($installation->slip_watermark);
            $type = pathinfo($wm, PATHINFO_EXTENSION);
            $wm = file_get_contents($wm);
            $wm = 'data:image/' . $type . ';base64,' . base64_encode($wm);
            $report .= view('employee-period.download', compact('employeePeriod','installation','title','logo','qrcode','wm'))->render();
        }

        // return $report;

        $options = new Options(); 
        $options->set('isPhpEnabled', 'true'); 
        
        $dompdf = new Dompdf($options);
        $dompdf->setPaper('Folio','portrait');


        $dompdf->loadHtml($report);
        $dompdf->render();

        $dompdf->stream('download.pdf',array("Attachment" => false));
    }
}
