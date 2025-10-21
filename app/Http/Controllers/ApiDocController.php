<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiDocController extends Controller
{
    /**
     * Affiche la documentation de l'API.
     */
    public function index()
    {
        $docPath = base_path('API_DOC.md');
        if (file_exists($docPath)) {
            $content = file_get_contents($docPath);
            return response($content, 200)
                ->header('Content-Type', 'text/markdown; charset=utf-8');
        } else {
            return response()->json([
                'error' => 'La documentation API_DOC.md est introuvable.'
            ], 404);
        }
    }
}
