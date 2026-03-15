<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Courrier;
use App\Models\Affectation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use setasign\Fpdi\Fpdi;
class CourrierController extends Controller
{

// 🔹 الرقم التالي حسب السنة
public function nextNumber(Request $request)
{

$annee = $request->annee ?? date('Y');

$last = Courrier::where('annee',$annee)
->orderByRaw('CAST(numero as UNSIGNED) desc')
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


// 🔹 تسجيل courrier جديد
public function store(Request $request)
{

$request->validate([
'numero'=>'required',
'annee'=>'required',
'type'=>'required',
'objet'=>'required',
'date_courrier'=>'required|date',
'service_id'=>'required',
'nature_id'=>'required'
]);

$courrier = Courrier::create([

'numero'=>$request->numero,
'annee'=>$request->annee,
'type'=>$request->type,
'objet'=>$request->objet,
'description'=>$request->description,
'date_courrier'=>$request->date_courrier,
'date_arrivee'=>$request->date_courrier,
'expediteur'=>$request->expediteur,
'destinataire'=>$request->destinataire,
'nombre_pieces'=>$request->nombre_pieces,
'observations'=>$request->observations,
'nature_id'=>$request->nature_id,
'user_id'=>1,
'status_id'=>1

]);

// 🔹 upload fichier
if($request->hasFile('fichier')){

$file = $request->file('fichier');

$folder = 'courriers/'.$courrier->annee;

$filename = 'courrier_'.$courrier->numero.'.'.$file->getClientOriginalExtension();

$path = $file->storeAs($folder,$filename,'public');

$courrier->fichier = $path;

$courrier->save();

}

// 🔹 affectation service
Affectation::create([

'courrier_id'=>$courrier->id,
'service_id'=>$request->service_id,
'date_affectation'=>now()

]);

return response()->json([
'message'=>'Courrier ajouté avec succès',
'courrier'=>$courrier
]);

}


// 🔹 liste courriers arrivée
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


// 🔹 Voir courrier (validation automatique)
public function valider($id)
{

$courrier = Courrier::findOrFail($id);

$courrier->status_id = 2;

$courrier->save();

return response()->json([
'message'=>'courrier validé'
]);

}


// 🔹 supprimer courrier
public function destroy($id)
{

$courrier = Courrier::findOrFail($id);

$courrier->delete();

return response()->json([
'message'=>'courrier supprimé'
]);

}


// 🔹 تحميل PDF
public function downloadPdf($id)
{
    $courrier = Courrier::with([
        'affectations.service',
        'nature'
    ])->findOrFail($id);

    $tempDir = storage_path('app/temp');

    if (!file_exists($tempDir)) {
        mkdir($tempDir, 0777, true);
    }

    // formulaire
    $formulaire = Pdf::loadView('pdf.courrier', [
        'courrier' => $courrier
    ]);

    $formulairePath = $tempDir . '/temp_formulaire_' . $courrier->id . '.pdf';
    file_put_contents($formulairePath, $formulaire->output());

    // pdf final
    $pdf = new Fpdi();

    $pageCount = $pdf->setSourceFile($formulairePath);

    for ($i = 1; $i <= $pageCount; $i++) {
        $template = $pdf->importPage($i);
        $size = $pdf->getTemplateSize($template);

        $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';

        $pdf->AddPage($orientation, [$size['width'], $size['height']]);
        $pdf->useTemplate($template);
    }

    // scan pdf
    if (!empty($courrier->fichier)) {
        $scanPath = storage_path('app/public/' . $courrier->fichier);

        if (file_exists($scanPath) && strtolower(pathinfo($scanPath, PATHINFO_EXTENSION)) === 'pdf') {
            $scanPageCount = $pdf->setSourceFile($scanPath);

            for ($i = 1; $i <= $scanPageCount; $i++) {
                $template = $pdf->importPage($i);
                $size = $pdf->getTemplateSize($template);

                $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';

                $pdf->AddPage($orientation, [$size['width'], $size['height']]);
                $pdf->useTemplate($template);
            }
        }
    }

    $finalPath = $tempDir . '/courrier_' . $courrier->id . '_final.pdf';

    $pdf->Output($finalPath, 'F');

    return response()->download(
        $finalPath,
        'courrier-' . $courrier->numero . '.pdf',
        ['Content-Type' => 'application/pdf']
    )->deleteFileAfterSend(true);
}

// 🔹 afficher courrier واحد (باش يتعمر formulaire modifier)
public function show($id)
{

$courrier = Courrier::with([
'affectations.service',
'nature'
])->findOrFail($id);

return response()->json($courrier);

}


// 🔹 modifier courrier
public function update(Request $request,$id)
{

$courrier = Courrier::findOrFail($id);

$courrier->update([

'type'=>$request->type,
'objet'=>$request->objet,
'description'=>$request->description,
'date_courrier'=>$request->date_courrier,
'date_arrivee'=>$request->date_courrier,
'expediteur'=>$request->expediteur,
'destinataire'=>$request->destinataire,
'nombre_pieces'=>$request->nombre_pieces,
'observations'=>$request->observations,
'nature_id'=>$request->nature_id

]);

// update service
$affectation = Affectation::where('courrier_id',$courrier->id)->first();

if($affectation){

$affectation->update([
'service_id'=>$request->service_id
]);

}

return response()->json([
'message'=>'courrier modifié'
]);

}
public function genererPdf($annee)
{

$courriers = Courrier::with([
'affectations.service',
'nature'
])
->where('annee',$annee)
->orderByRaw('CAST(numero as UNSIGNED) asc')
->get();

$pdf = Pdf::loadView('pdf.liste_courriers',[
'courriers'=>$courriers,
'annee'=>$annee
]);

return $pdf->download("liste-courriers-".$annee.".pdf");

}
}