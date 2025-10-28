<?php

namespace App\Http\Controllers;

use App\Imports\CompetitionImport;
use App\Exports\CompetitionExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Models\Competition;

class CompetitionImportExportController extends Controller
{
    public function import(Request $request)
    {
        $file = $request->file('file');
        $import = new CompetitionImport();
        Excel::import($import, $file);
        Session::flash('import_report', [
            'succès' => 'Import terminé',
            'créés' => count($import->created) ? implode(', ', $import->created) : 'Aucun',
            'modifiés' => count($import->updated) ? implode(', ', $import->updated) : 'Aucun',
            'erronés' => count($import->errors) ? implode(', ', $import->errors) : 'Aucun',
        ]);
        return redirect()->route('competitions.index');
    }

    public function export(Request $request)
    {
        $selected = $request->input('ids');
        $ids = $selected ? explode(',', $selected) : [];
        return Excel::download(new CompetitionExport($ids), 'competitions.xlsx');
    }
}
