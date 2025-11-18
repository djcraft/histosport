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
            Session::flash('notification', [
                'type' => 'success',
                'message' => 'Import terminé.<br>'
                    . 'Créés : ' . (is_array($import->created) ? implode(', ', $import->created) : $import->created) . '<br>'
                    . 'Modifiés : ' . (is_array($import->updated) ? implode(', ', $import->updated) : $import->updated) . '<br>'
                    . 'Erreurs : ' . (is_array($import->errors) ? implode(', ', $import->errors) : $import->errors)
            ]);
        return redirect()->route('lieux.index');
    }

    public function export(Request $request)
    {
    $selected = $request->input('ids');
    $ids = array_filter($selected ? explode(',', $selected) : []);
    return Excel::download(new LieuExport($ids ?: null), 'lieux_export.xlsx');
    }
}
