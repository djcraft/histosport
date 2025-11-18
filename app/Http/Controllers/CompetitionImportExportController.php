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
            Session::flash('notification', [
                'type' => 'success',
                'message' => 'Import terminé.<br>'
                    . 'Créés : ' . (is_array($import->created) ? implode(', ', $import->created) : $import->created) . '<br>'
                    . 'Modifiés : ' . (is_array($import->updated) ? implode(', ', $import->updated) : $import->updated) . '<br>'
                    . 'Erreurs : ' . (is_array($import->errors) ? implode(', ', $import->errors) : $import->errors)
            ]);
        return redirect()->route('competitions.index');
    }

    public function export(Request $request)
    {
    $selected = $request->input('ids');
    $ids = array_filter($selected ? explode(',', $selected) : []);
    return Excel::download(new CompetitionExport($ids ?: null), 'competitions.xlsx');
    }
}
