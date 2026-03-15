<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Page d'accueil
|--------------------------------------------------------------------------
*/
Route::get('/courrier-departs', function () {
    return Inertia::render('CourrierDeparts/ListCourrierDeparts');
});
Route::get('/', [HomeController::class, 'index'])->name('home');

// Liste
Route::get('/courrier-departs', function () {
    return Inertia::render('ListCourrierDeparts');
})->name('courrier-departs.index');

// Ajouter
Route::get('/courrier-departs/create', function () {
    return Inertia::render('CreateCourrierDepart');
})->name('courrier-departs.create');
/*
|--------------------------------------------------------------------------
| Courrier Départ
|--------------------------------------------------------------------------
*/

Route::get('/courrier-departs/create', function () {
    return Inertia::render('CreateCourrierDepart');
});


/*
|--------------------------------------------------------------------------
| Courriers Arrivée
|--------------------------------------------------------------------------
*/

// Liste
Route::get('/courriers', function () {
    return Inertia::render('ListCourriers');
})->name('courriers.index');


// Ajouter + Modifier (نفس الصفحة)
Route::get('/courriers/create', function () {
    return Inertia::render('CreateCourrier');
})->name('courriers.create');


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';