<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourrierController;
use App\Http\Controllers\Api\ServiceController;


// 🔹 récupérer le prochain numéro de courrier
Route::get('/courriers/next-number', [CourrierController::class, 'nextNumber']);


// 🔹 ajouter un courrier
Route::post('/courriers', [CourrierController::class, 'store']);


// 🔹 liste des courriers
Route::get('/courriers', [CourrierController::class, 'index']);


// 🔹 télécharger formulaire PDF
Route::get('/courriers/{id}/pdf', [CourrierController::class, 'downloadPdf']);


// 🔹 liste des services
Route::get('/services', [ServiceController::class, 'index']);