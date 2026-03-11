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

// 🔹 récupérer le prochain numéro de courrier حسب السنة
Route::get('/courriers/next-number', [CourrierController::class, 'nextNumber']);


// 🔹 ajouter un courrier
Route::post('/courriers', [CourrierController::class, 'store']);


// 🔹 liste des courriers
Route::get('/courriers', [CourrierController::class, 'index']);


// 🔹 télécharger PDF courrier
Route::get('/courriers/{id}/pdf', [CourrierController::class, 'downloadPdf']);


// 🔹 récupérer liste des services
Route::get('/services', [ServiceController::class, 'index']);


// 🔹 ajouter service depuis select
Route::post('/services', [ServiceController::class, 'store']);

Route::get('/natures', [NatureController::class, 'index']);

Route::get('/courrier-departs/next-number',[CourrierDepartController::class,'nextNumber']);

Route::post('/courrier-departs',[CourrierDepartController::class,'store']);

Route::get('/courrier-departs',[CourrierDepartController::class,'index']);