<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\DisciplineExport;
use App\Imports\DisciplineImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class DisciplineImportExportController extends Controller
{
    public function import(Request $request)
    {
        $file = $request->file('file');
        $import = new DisciplineImport();
        Excel::import($import, $file);
            Session::flash('notification', [
                'type' => 'success',
                'message' => 'Import terminé.<br>'
                    . 'Créés : ' . (is_array($import->created) ? implode(', ', $import->created) : $import->created) . '<br>'
                    . 'Modifiés : ' . (is_array($import->updated) ? implode(', ', $import->updated) : $import->updated) . '<br>'
                    . 'Erreurs : ' . (is_array($import->errors) ? implode(', ', $import->errors) : $import->errors)
            ]);
        return redirect()->route('disciplines.index');
    }

    public function export(Request $request)
    {
    $selected = $request->input('ids');
    $ids = array_filter($selected ? explode(',', $selected) : []);
    return Excel::download(new DisciplineExport($ids ?: null), 'disciplines.xlsx');
    }
}
