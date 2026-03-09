<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Courrier;
use App\Models\Affectation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CourrierController extends Controller
{

    // 🔹 يرجع الرقم التالي ديال courrier
    public function nextNumber()
    {

        $last = Courrier::latest()->first();

        if (!$last) {

            $numero = "2026-001";

        } else {

            $number = intval(substr($last->numero, -3)) + 1;

            $numero = "2026-" . str_pad($number, 3, "0", STR_PAD_LEFT);

        }

        return response()->json([
            'numero' => $numero
        ]);

    }


    // 🔹 تسجيل courrier جديد
    public function store(Request $request)
    {
        dd(auth()->id());
        $courrier = Courrier::create([
            'numero' => $request->numero,
            'type' => $request->type,
            'objet' => $request->objet,
            'description' => $request->description,
            'date_courrier' => $request->date_courrier,
            'expediteur' => $request->expediteur,
            'destinataire' => $request->destinataire,
            'user_id' => 1,
            'status_id' => 1,
        ]);

        // 🔹 upload fichier
        if ($request->hasFile('fichier')) {

            $file = $request->file('fichier');

            $folder = 'courriers/' . $courrier->numero;

            $filename = 'courrier_' . $courrier->numero . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs($folder, $filename, 'public');

            $courrier->fichier = $path;

            $courrier->save();
        }

        // 🔹 affectation service
        Affectation::create([
            'courrier_id' => $courrier->id,
            'service_id' => $request->service_id,
            'date_affectation' => now()
        ]);

        return response()->json([
            'message' => 'Courrier ajouté',
            'courrier' => $courrier
        ]);

    }


    // 🔹 liste des courriers
    public function index()
    {

        $courriers = Courrier::with('affectations.service')
            ->latest()
            ->get();

        return response()->json($courriers);

    }


    // 🔹 télécharger formulaire PDF
    public function downloadPdf($id)
    {

        $courrier = Courrier::with('affectations.service')
            ->findOrFail($id);

        $pdf = Pdf::loadView('pdf.courrier', [
            'courrier' => $courrier
        ]);

        return $pdf->download('courrier_' . $courrier->numero . '.pdf');

    }

}