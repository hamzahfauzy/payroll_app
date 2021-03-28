<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class PositionController
 * @package App\Http\Controllers
 */
class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = Position::paginate();

        return view('position.index', compact('positions'))
            ->with('i', (request()->input('page', 1) - 1) * $positions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $position = new Position();
        return view('position.create', compact('position'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Position::$rules);

        $position = Position::create($request->all());

        return redirect()->route('positions.index')
            ->with('success', 'Position created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $position = Position::find($id);

        return view('position.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $position = Position::find($id);

        return view('position.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Position $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        request()->validate(Position::$rules);

        $position->update($request->all());

        return redirect()->route('positions.index')
            ->with('success', 'Position updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $position = Position::find($id)->delete();

        return redirect()->route('positions.index')
            ->with('success', 'Position deleted successfully');
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
                    Position::create([
                        'name' => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
                        'sallary' => $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
                        'cost' => $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
                    ]);
                }
                DB::commit();
                return redirect()->route('positions.index')
                    ->with('success', 'Position imported successfully');
            } catch (\Throwable $th) {
                DB::rollback();
                return redirect()->route('positions.index')
                    ->with('error', 'Position imported failed');
                // throw $th;
            }
        }
        return view('position.import');
    }
}
