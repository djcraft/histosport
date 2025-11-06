<?php

namespace App\Http\Controllers;

use App\Imports\SourceImport;
use App\Exports\SourceExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class SourceImportExportController extends Controller
{
    public function import(Request $request)
    {
        $import = new SourceImport();
        Excel::import($import, $request->file('file'));
        Session::flash('import_report', [
            'created' => $import->created,
            'updated' => $import->updated,
            'errors' => $import->errors,
        ]);
        return redirect()->route('sources.index');
    }

    public function export(Request $request)
    {
    $selected = $request->input('ids');
    $ids = array_filter($selected ? explode(',', $selected) : []);
    return Excel::download(new SourceExport($ids ?: null), 'sources_export.xlsx');
    }
}
