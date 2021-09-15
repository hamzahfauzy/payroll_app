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
        if(isset($_GET['keyword']) && !empty($_GET['keyword']))
        {
            $keyword = $_GET['keyword'];
            $employees = Employee::join('positions','positions.id','=','employees.position_id')->where('employees.NIK','like','%'.$keyword.'%')
                            ->orwhere('employees.name','like','%'.$keyword.'%')
                            ->orwhere('employees.work_around','like','%'.$keyword.'%')
                            ->orwhere('employees.bank_account','like','%'.$keyword.'%')
                            ->orwhere('positions.name','like','%'.$keyword.'%')
                            ->select('employees.*','positions.id as pos_id','positions.name as pos_name')
                            ->paginate();
        }

        return view('employee.index', compact('employees'))
            ->with('i', (request()->input('page', 1) - 1) * $employees->perPage());
    }

    public function export()
    {
        $employees   = Employee::with('position')->get();

        $employees_row = "";
        foreach($employees as $key => $employee)
        {
            $employees_row .= "<tr>
            <td>".($key+1)."</td>
            <td>'".$employee->NIK."</td>
            <td>'".$employee->NPWP."</td>
            <td>".$employee->name."</td>
            <td>".str_replace('&',' dan ', $employee->jabatan)."</td>
            <td>".$employee->work_around."</td>
            <td>'".$employee->bank_account."</td>
            <td>".$employee->main_sallary."</td>
            </tr>
            ";
        }

        $html = "
        <table>
            <tr>
                <td>No</td>
                <td>NIK</td>
                <td>NPWP</td>
                <td>NAMA</td>
                <td>JABATAN</td>
                <td>AREA KERJA</td>
                <td>NO REKENING</td>
                <td>GAJI POKOK</td>
            </tr>
            $employees_row
        </table>
        ";

        $filename = 'format-import/all-employees-'.date('Y-m-d').'.xls';

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        $spreadsheet = $reader->loadFromString($html);

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save($filename); 

        return redirect($filename);
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
                'email' => $request->username,
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
                'email' => $request->username
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

    public function import(Request $request)
    {
        if ($request->isMethod("post"))
        {
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

            DB::beginTransaction();
            try {
                //code...
                for ($row = 2; $row <= $highestRow; $row++) { //$row = 2 artinya baris kedua yang dibaca dulu(header kolom diskip disesuaikan saja)
                    if(empty($worksheet->getCellByColumnAndRow(1, $row)->getValue())) break;
                    $data_user = [
                        'name' => $worksheet->getCellByColumnAndRow(5, $row)->getValue(),
                        'email' => $worksheet->getCellByColumnAndRow(9, $row)->getValue(),
                        'password' => $worksheet->getCellByColumnAndRow(10, $row)->getValue(),
                    ];
                    if(User::where('email',$worksheet->getCellByColumnAndRow(9, $row)->getValue())->exists())
                    {
                        $user = User::where('email',$worksheet->getCellByColumnAndRow(9, $row)->getValue())->first();
                        $user->update($data_user);
                    }
                    else
                        $user = User::create($data_user);
                    $position = Position::where('name',$worksheet->getCellByColumnAndRow(2, $row)->getValue());
                    if(!$position->exists())
                    {
                        $position = Position::create([
                            'name' => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
                            'sallary' => 0,
                            'cost' => 0,
                        ]);
                    }
                    else $position = $position->first();
                    Employee::updateOrCreate([
                        'user_id' => $user->id
                    ],[
                        'position_id' => $position->id,
                        'user_id' => $user->id,
                        'NIK' => $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
                        'NPWP' => $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
                        'name' => $worksheet->getCellByColumnAndRow(5, $row)->getValue(),
                        'work_around' => $worksheet->getCellByColumnAndRow(6, $row)->getValue(),
                        'bank_account' => $worksheet->getCellByColumnAndRow(7, $row)->getValue(),
                        'main_sallary' => $worksheet->getCellByColumnAndRow(8, $row)->getValue(),
                    ]);
                }
                DB::commit();
                return redirect()->route('employees.index')
                    ->with('success', 'Employee imported successfully');
            } catch (\Throwable $th) {
                DB::rollback();
                // return redirect()->route('emloyees.index')
                //     ->with('error', 'Position imported failed');
                throw $th;
            }
        }
        return view('employee.import');
    }

    public function deleteAll()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Employee::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        Employee::whereIn('id',$request->delete)->delete();
        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully');
    }
}
