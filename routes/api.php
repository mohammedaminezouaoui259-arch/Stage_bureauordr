<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourrierController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\NatureController;
use App\Http\Controllers\Api\CourrierDepartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


// 🔹 next numero
Route::get('/courriers/next-number',[CourrierController::class,'nextNumber']);


// 🔹 ajouter courrier
Route::post('/courriers',[CourrierController::class,'store']);


// 🔹 liste courrier arrivée
Route::get('/courriers',[CourrierController::class,'index']);


// 🔹 valider courrier (Voir)
Route::put('/courriers/{id}/valider',[CourrierController::class,'valider']);


// 🔹 supprimer courrier
Route::delete('/courriers/{id}',[CourrierController::class,'destroy']);


// 🔹 télécharger PDF
Route::get('/courriers/{id}/pdf',[CourrierController::class,'downloadPdf']);


// 🔹 services
Route::get('/services',[ServiceController::class,'index']);
Route::post('/services',[ServiceController::class,'store']);


// 🔹 natures
Route::get('/natures',[NatureController::class,'index']);


// 🔹 courrier départ
Route::get('/courrier-departs/next-number',[CourrierDepartController::class,'nextNumber']);
Route::post('/courrier-departs',[CourrierDepartController::class,'store']);
Route::get('/courrier-departs',[CourrierDepartController::class,'index']);
Route::get('/courrier-departs/{id}', [CourrierDepartController::class, 'show']);
Route::put('/courrier-departs/{id}/valider', [CourrierDepartController::class, 'valider']);
Route::put('/courrier-departs/{id}', [CourrierDepartController::class, 'update']);
Route::delete('/courrier-departs/{id}', [CourrierDepartController::class, 'destroy']);
Route::get('/courrier-departs/download/{id}', [CourrierDepartController::class, 'downloadPdf']);
Route::get('/courrier-departs/generer-pdf/{annee}', [CourrierDepartController::class, 'genererPdf']);
//modifier
Route::get('/courriers/{id}',[CourrierController::class,'show']);

Route::post('/courriers/{id}',[CourrierController::class,'update']);

//liste generer pdf
Route::get('/courriers/generer-pdf/{annee}', [CourrierController::class,'genererPdf']);

//telecharger pdf
Route::get('/courriers/download/{id}', [CourrierController::class,'downloadPdf']);