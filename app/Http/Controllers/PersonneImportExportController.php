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
            Session::flash('notification', [
                'type' => 'success',
                'message' => 'Import terminé.<br>'
                    . 'Créés : ' . (is_array($import->created) ? implode(', ', $import->created) : $import->created) . '<br>'
                    . 'Modifiés : ' . (is_array($import->updated) ? implode(', ', $import->updated) : $import->updated) . '<br>'
                    . 'Erreurs : ' . (is_array($import->errors) ? implode(', ', $import->errors) : $import->errors)
            ]);
        return redirect()->route('personnes.index');
    }

    public function export(Request $request)
    {
        $selected = $request->input('selected');
        $ids = array_filter($selected ? explode(',', $selected) : []);
        return Excel::download(new PersonneExport($ids ?: null), 'personnes.xlsx');
    }
}
