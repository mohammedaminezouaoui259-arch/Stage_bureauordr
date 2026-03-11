<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Courrier;
use App\Models\Affectation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CourrierController extends Controller
{

    // 🔹 الرقم التالي حسب السنة
    public function nextNumber(Request $request)
    {

        $annee = $request->annee ?? date('Y');

        $last = Courrier::where('annee', $annee)
            ->orderByRaw('CAST(numero as UNSIGNED) desc')
            ->first();

        if (!$last) {

            $numero = "001";

        } else {

            $number = intval($last->numero) + 1;

            $numero = str_pad($number, 3, "0", STR_PAD_LEFT);

        }

        return response()->json([
            'numero' => $numero
        ]);
    }


    // 🔹 تسجيل courrier جديد
    public function store(Request $request)
    {

        $request->validate([
            'numero' => 'required',
            'annee' => 'required',
            'objet' => 'required',
            'date_courrier' => 'required|date',
            'service_id' => 'required',
            'nature_id' => 'required'
        ]);

        $courrier = Courrier::create([

            'numero' => $request->numero,
            'annee' => $request->annee,
            'type' => $request->type,
            'objet' => $request->objet,
            'description' => $request->description,
            'date_courrier' => $request->date_courrier,
            'expediteur' => $request->expediteur,
            'destinataire' => $request->destinataire,
            'nombre_pieces' => $request->nombre_pieces,
            'observations' => $request->observations,
            'nature_id' => $request->nature_id,
            'user_id' => 1,
            'status_id' => 1

        ]);


        // 🔹 upload fichier
        if ($request->hasFile('fichier')) {

            $file = $request->file('fichier');

            $folder = 'courriers/' . $courrier->annee;

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
            'message' => 'Courrier ajouté avec succès',
            'courrier' => $courrier
        ]);

    }


    // 🔹 liste courriers
    public function index()
    {

        $courriers = Courrier::with([
            'affectations.service',
            'nature',
            'status'
        ])
        ->orderBy('annee','desc')
        ->orderByRaw('CAST(numero as UNSIGNED) desc')
        ->get();

        return response()->json($courriers);

    }


    // 🔹 تحميل PDF
    public function downloadPdf($id)
    {

        $courrier = Courrier::with([
            'affectations.service',
            'nature'
        ])
        ->findOrFail($id);

        $pdf = Pdf::loadView('pdf.courrier', [
            'courrier' => $courrier
        ]);

        return $pdf->download('courrier_' . $courrier->numero . '.pdf');

    }

}