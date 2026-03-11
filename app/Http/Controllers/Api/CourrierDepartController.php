<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourrierDepart;

class CourrierDepartController extends Controller
{

    // générer numéro automatique
    public function nextNumber(Request $request)
    {
        $annee = $request->annee ?? date('Y');

        $last = CourrierDepart::where('annee',$annee)
            ->orderBy('numero','desc')
            ->first();

        if(!$last){
            $numero = "001";
        }else{
            $number = intval($last->numero) + 1;
            $numero = str_pad($number,3,"0",STR_PAD_LEFT);
        }

        return response()->json([
            'numero'=>$numero
        ]);
    }


    // enregistrer courrier départ
    public function store(Request $request)
    {

        $request->validate([
            'numero' => 'required',
            'objet' => 'required',
            'type' => 'required',
            'date_depart' => 'required',
            'destinataire_externe' => 'required',
            'mode_envoi' => 'required',
            'nature_id' => 'required'
        ]);

        $courrier = CourrierDepart::create([

            'numero'=>$request->numero,
            'annee'=>$request->annee,
            'objet'=>$request->objet,
            'type'=>$request->type,
            'date_depart'=>$request->date_depart,
            'destinataire_externe'=>$request->destinataire_externe,
            'mode_envoi'=>$request->mode_envoi,
            'description'=>$request->description,
            'nombre_pieces'=>$request->nombre_pieces,
            'observations'=>$request->observations,
            'nature_id'=>$request->nature_id,
            'courrier_arrive_id'=>$request->courrier_arrive_id,
            'user_id'=>1

        ]);

        if($request->hasFile('fichier')){

            $file = $request->file('fichier');

            $path = $file->store('courrier_departs','public');

            $courrier->fichier = $path;

            $courrier->save();

        }

        return response()->json([
            'message'=>'Courrier départ ajouté avec succès',
            'courrier'=>$courrier
        ]);

    }


    // liste courriers départ
    public function index()
    {

        $courriers = CourrierDepart::with(['nature','courrierArrive'])
            ->latest()
            ->get();

        return response()->json($courriers);

    }

}