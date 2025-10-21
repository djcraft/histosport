<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\PersonneController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\LieuController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\CompetitionParticipantController;
use App\Http\Controllers\ApiDocController;
// Documentation API
Route::get('/', [ApiDocController::class, 'index']);
Route::apiResource('clubs', ClubController::class);
Route::apiResource('personnes', PersonneController::class);
Route::apiResource('disciplines', DisciplineController::class);
Route::apiResource('lieux', LieuController::class);
Route::apiResource('competitions', CompetitionController::class);
Route::apiResource('sources', SourceController::class);
Route::apiResource('competition_participant', CompetitionParticipantController::class);

// Historisation (exemple d'accès à l'historique d'une entité)
Route::get('{entity}/{id}/historisations', function ($entity, $id) {
    $model = 'App\\Models\\' . ucfirst($entity);
    if (class_exists($model)) {
        $instance = $model::findOrFail($id);
        return response()->json($instance->historisations);
    }
    return response()->json(['error' => 'Entité inconnue'], 404);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
