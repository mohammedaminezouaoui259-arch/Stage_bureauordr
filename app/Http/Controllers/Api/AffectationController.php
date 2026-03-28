<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Affectation;

class AffectationController extends Controller
{
    // 📌 liste
    public function index()
    {
        return Affectation::with(['courrier','service'])->get();
    }

    // 📌 ajouter affectation
    public function store(Request $request)
    {
        $request->validate([
            'date_affectation' => 'required|date',
            'message' => 'required',
            'courrier_id' => 'required|exists:courriers,id',
            'service_id' => 'required|exists:services,id',
        ]);

        // ⚠️ éviter duplication (hit unique)
        $exist = Affectation::where('courrier_id',$request->courrier_id)->first();

        if($exist){
            return response()->json(['message'=>'Courrier déjà affecté'],400);
        }

        $affectation = Affectation::create($request->all());

        return response()->json([
            'message'=>'Affectation ajoutée avec succès',
            'data'=>$affectation
        ]);
    }

    // 📌 show
    public function show($id)
    {
        return Affectation::with(['courrier','service'])->findOrFail($id);
    }

    // 📌 delete
    public function destroy($id)
    {
        $affectation = Affectation::findOrFail($id);
        $affectation->delete();

        return response()->json([
            'message'=>'Affectation supprimée'
        ]);
    }
}