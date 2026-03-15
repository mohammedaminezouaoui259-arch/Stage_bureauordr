<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourrierDepart;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use iio\libmergepdf\Merger;

class CourrierDepartController extends Controller
{
    public function nextNumber(Request $request)
    {
        $annee = $request->annee ?? date('Y');

        $last = CourrierDepart::where('annee', $annee)
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

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required',
            'annee' => 'required',
            'objet' => 'required',
            'type' => 'nullable',
            'date_depart' => 'required|date',
            'destinataire_externe' => 'required',
            'mode_envoi' => 'required',
            'nature_id' => 'required'
        ]);

        $courrier = CourrierDepart::create([
            'numero' => $request->numero,
            'annee' => $request->annee,
            'objet' => $request->objet,
            'type' => $request->type,
            'date_depart' => $request->date_depart,
            'destinataire_externe' => $request->destinataire_externe,
            'mode_envoi' => $request->mode_envoi,
            'description' => $request->description,
            'nombre_pieces' => $request->nombre_pieces,
            'observations' => $request->observations,
            'nature_id' => $request->nature_id,
            'courrier_arrive_id' => $request->courrier_arrive_id ?: null,
            'user_id' => 1,
            'status_id' => 1
        ]);

        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $folder = 'courrier_departs/' . $courrier->annee;
            $filename = 'courrier_depart_' . $courrier->numero . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs($folder, $filename, 'public');

            $courrier->fichier = $path;
            $courrier->save();
        }

        return response()->json([
            'message' => 'Courrier départ ajouté avec succès',
            'courrier' => $courrier
        ]);
    }

    public function index()
    {
        $courriers = CourrierDepart::with(['nature', 'courrierArrive'])
            ->orderBy('annee', 'desc')
            ->orderByRaw('CAST(numero as UNSIGNED) desc')
            ->get();

        return response()->json($courriers);
    }

    public function show($id)
    {
        $courrier = CourrierDepart::with(['nature', 'courrierArrive'])->findOrFail($id);

        return response()->json($courrier);
    }

    public function valider($id)
    {
        $courrier = CourrierDepart::findOrFail($id);
        $courrier->status_id = 2;
        $courrier->save();

        return response()->json([
            'message' => 'Courrier départ validé avec succès'
        ]);
    }

    public function update(Request $request, $id)
    {
        $courrier = CourrierDepart::findOrFail($id);

        $request->validate([
            'objet' => 'required',
            'date_depart' => 'required|date',
            'destinataire_externe' => 'required',
            'mode_envoi' => 'required',
            'nature_id' => 'required'
        ]);

        $courrier->update([
            'objet' => $request->objet,
            'type' => $request->type,
            'date_depart' => $request->date_depart,
            'destinataire_externe' => $request->destinataire_externe,
            'mode_envoi' => $request->mode_envoi,
            'description' => $request->description,
            'nombre_pieces' => $request->nombre_pieces,
            'observations' => $request->observations,
            'nature_id' => $request->nature_id,
            'courrier_arrive_id' => $request->courrier_arrive_id ?: null,
        ]);

        if ($request->hasFile('fichier')) {
            if ($courrier->fichier && Storage::disk('public')->exists($courrier->fichier)) {
                Storage::disk('public')->delete($courrier->fichier);
            }

            $file = $request->file('fichier');
            $folder = 'courrier_departs/' . $courrier->annee;
            $filename = 'courrier_depart_' . $courrier->numero . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs($folder, $filename, 'public');

            $courrier->fichier = $path;
            $courrier->save();
        }

        return response()->json([
            'message' => 'Courrier départ modifié avec succès',
            'courrier' => $courrier
        ]);
    }

    public function destroy($id)
    {
        $courrier = CourrierDepart::findOrFail($id);

        if ($courrier->fichier && Storage::disk('public')->exists($courrier->fichier)) {
            Storage::disk('public')->delete($courrier->fichier);
        }

        $courrier->delete();

        return response()->json([
            'message' => 'Courrier départ supprimé avec succès'
        ]);
    }

    public function downloadPdf($id)
    {
        $courrier = CourrierDepart::with(['nature', 'courrierArrive'])->findOrFail($id);

        $pdf = Pdf::loadView('pdf.courrier_depart', [
            'courrier' => $courrier
        ]);

        $formPdfContent = $pdf->output();

        if ($courrier->fichier && Storage::disk('public')->exists($courrier->fichier)) {
            $scanPath = Storage::disk('public')->path($courrier->fichier);

            $merger = new Merger();
            $merger->addRaw($formPdfContent);
            $merger->addFile($scanPath);

            $mergedPdf = $merger->merge();

            return response($mergedPdf, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="courrier-depart-' . $courrier->numero . '.pdf"',
            ]);
        }

        return $pdf->download('courrier-depart-' . $courrier->numero . '.pdf');
    }

    public function genererPdf($annee)
    {
        $courriers = CourrierDepart::with(['nature', 'courrierArrive'])
            ->where('annee', $annee)
            ->orderByRaw('CAST(numero as UNSIGNED) asc')
            ->get();

        $pdf = Pdf::loadView('pdf.liste_courriers_departs', [
            'courriers' => $courriers,
            'annee' => $annee
        ]);

        return $pdf->download('liste-courriers-departs-' . $annee . '.pdf');
    }
}