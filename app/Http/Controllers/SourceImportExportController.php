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
        $file = $request->file('file');
        $import = new SourceImport();
        Excel::import($import, $file);
        Session::flash('notification', [
            'type' => 'success',
            'message' => 'Import terminé.<br>'
                . 'Créés : ' . (is_array($import->created) ? implode(', ', $import->created) : $import->created) . '<br>'
                . 'Modifiés : ' . (is_array($import->updated) ? implode(', ', $import->updated) : $import->updated) . '<br>'
                . 'Erreurs : ' . (is_array($import->errors) ? implode(', ', $import->errors) : $import->errors)
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
