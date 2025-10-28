<?php

namespace App\Http\Controllers;

use App\Imports\PersonneImport;
use App\Exports\PersonneExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Models\Personne;

class PersonneImportExportController extends Controller
{
    public function import(Request $request)
    {
        $file = $request->file('file');
        $import = new PersonneImport();
        Excel::import($import, $file);
        Session::flash('import_report', [
            'succès' => 'Import terminé',
            'créés' => count($import->created) ? implode(', ', $import->created) : 'Aucun',
            'modifiés' => count($import->updated) ? implode(', ', $import->updated) : 'Aucun',
            'erronés' => count($import->errors) ? implode(', ', $import->errors) : 'Aucun',
        ]);
        return redirect()->route('personnes.index');
    }

    public function export(Request $request)
    {
        $selected = $request->input('selected');
        $ids = $selected ? explode(',', $selected) : [];
        $personnes = count($ids)
            ? Personne::with(['clubs'])->whereIn('id', $ids)->get()
            : Personne::with(['clubs'])->get();
        return Excel::download(new PersonneExport($personnes), 'personnes.xlsx');
    }
}
