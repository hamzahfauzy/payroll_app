<?php

namespace App\Http\Controllers;

use App\Models\Sallary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                    Sallary::create([
                        'name' => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
                        'sallary_type' => $worksheet->getCellByColumnAndRow(3, $row)->getValue()
                    ]);
                }
                DB::commit();
                return redirect()->route('sallaries.index')
                    ->with('success', 'Sallary imported successfully');
            } catch (\Throwable $th) {
                DB::rollback();
                // return redirect()->route('emloyees.index')
                //     ->with('error', 'Position imported failed');
                throw $th;
            }
        }
        return view('sallary.import');
    }
}
