<?php

namespace App\Http\Controllers;

use App\Imports\LieuImport;
use App\Exports\LieuExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class LieuImportExportController extends Controller
{
    public function import(Request $request)
    {
        $import = new LieuImport();
        Excel::import($import, $request->file('file'));
        Session::flash('import_report', [
            'created' => $import->created,
            'updated' => $import->updated,
            'errors' => $import->errors,
        ]);
        return redirect()->route('lieux.index');
    }

    public function export(Request $request)
    {
        $ids = $request->input('ids', null);
        return Excel::download(new LieuExport($ids), 'lieux_export.xlsx');
    }
}
