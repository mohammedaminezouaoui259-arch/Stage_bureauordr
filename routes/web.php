
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourrierController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Page d'accueil
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/courrier-departs/create', function () {
    return inertia('CreateCourrierDepart');
});
/*
|--------------------------------------------------------------------------
| Courriers (Pages React via Inertia)
|--------------------------------------------------------------------------
*/

// Liste des courriers
Route::get('/courriers', [CourrierController::class, 'index'])->name('courriers.index');

// Page Ajouter Courrier
Route::get('/courriers/create', function () {
    return Inertia::render('CreateCourrier');
})->name('courriers.create');

// Enregistrer courrier
Route::post('/courriers', [CourrierController::class, 'submit'])->name('courriers.store');


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
