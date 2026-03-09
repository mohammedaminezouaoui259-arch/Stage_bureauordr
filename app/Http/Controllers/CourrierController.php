<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Courrier;

class CourrierController extends Controller
{
    public function index()
    {

        $courriers = Courrier::with('affectations.service')
            ->latest()
            ->get();

        return Inertia::render('ListCourriers', [
            'courriers' => $courriers
        ]);
    }
}