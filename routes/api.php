<?php
use App\Http\Controllers\Api\AffectationController;
use App\Http\Controllers\Api\CourrierController;
use App\Http\Controllers\Api\CourrierDepartController;
use App\Http\Controllers\Api\NatureController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 🔹 next numero
Route::get('/courriers/next-number', [CourrierController::class, 'nextNumber']);

// 🔹 ajouter courrier
Route::post('/courriers', [CourrierController::class, 'store']);

// 🔹 liste courrier arrivée
Route::get('/courriers', [CourrierController::class, 'index']);

// 🔹 valider courrier (Voir)
Route::put('/courriers/{id}/valider', [CourrierController::class, 'valider']);

// 🔹 supprimer courrier
Route::delete('/courriers/{id}', [CourrierController::class, 'destroy']);

// 🔹 télécharger PDF
Route::get('/courriers/{id}/pdf', [CourrierController::class, 'downloadPdf']);

// 🔹 services
Route::get('/services', [ServiceController::class, 'index']);
Route::post('/services', [ServiceController::class, 'store']);

// 🔹 natures
Route::get('/natures', [NatureController::class, 'index']);

// 🔹 courrier départ
Route::get('/courrier-departs/next-number', [CourrierDepartController::class, 'nextNumber']);
Route::post('/courrier-departs', [CourrierDepartController::class, 'store']);
Route::get('/courrier-departs', [CourrierDepartController::class, 'index']);
Route::get('/courrier-departs/{id}', [CourrierDepartController::class, 'show']);
Route::put('/courrier-departs/{id}/valider', [CourrierDepartController::class, 'valider']);
Route::put('/courrier-departs/{id}', [CourrierDepartController::class, 'update']);
Route::delete('/courrier-departs/{id}', [CourrierDepartController::class, 'destroy']);
Route::get('/courrier-departs/download/{id}', [CourrierDepartController::class, 'downloadPdf']);
Route::get('/courrier-departs/generer-pdf/{annee}', [CourrierDepartController::class, 'genererPdf']);
Route::get('/courrier-departs/export-excel', [CourrierDepartController::class, 'exportExcel']);
Route::post('/courrier-departs/import-excel', [CourrierDepartController::class, 'importExcel']);
// modifier
Route::get('/courriers/{id}', [CourrierController::class, 'show']);

Route::post('/courriers/{id}', [CourrierController::class, 'update']);

// liste generer pdf
Route::get('/courriers/generer-pdf/{annee}', [CourrierController::class, 'genererPdf']);

// telecharger pdf
Route::get('/courriers/download/{id}', [CourrierController::class, 'downloadPdf']);
// user
Route::get('/users', [UserController::class, 'index']);
// Route::post('/users',[UserController::class,'store']);
// Route::get('/users/{id}',[UserController::class,'show']);
Route::put('/users/{id}', [UserController::class, 'update']);
// Route::delete('/users/{id}',[UserController::class,'destroy']);
// ///////////////////////////////////////////
// // Route::get('/users', function () {
// //     return \App\Models\User::all();
// // });
// //////////////////////////////////////////
// Route::post('/users/update', function (\Illuminate\Http\Request $request) {

//     $user = \App\Models\User::findOrFail($request->id);

//     $user->role = $request->role;
//     $user->is_active = $request->is_active;
//     $user->nature_id = $request->nature_id;
//     $user->service = $request->service;

//     $user->save();

//     return response()->json(['success'=>true]);
// });
//affectation
Route::get('/affectations',[AffectationController::class,'index']);
Route::post('/affectations',[AffectationController::class,'store']);
Route::get('/affectations/{id}',[AffectationController::class,'show']);
Route::delete('/affectations/{id}',[AffectationController::class,'destroy']);
