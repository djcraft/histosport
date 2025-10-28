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
        Session::flash('import_report', [
            'succès' => 'Import terminé',
            'créés' => count($import->created) ? implode(', ', $import->created) : 'Aucun',
            'modifiés' => count($import->updated) ? implode(', ', $import->updated) : 'Aucun',
            'erronés' => count($import->errors) ? implode(', ', $import->errors) : 'Aucun',
        ]);
        return redirect()->route('disciplines.index');
    }

    public function export(Request $request)
    {
        $selected = $request->input('ids');
        $ids = $selected ? explode(',', $selected) : [];
        return Excel::download(new DisciplineExport($ids), 'disciplines.xlsx');
    }
}
