<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Courrier Départ</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            margin: 30px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        .row {
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
        }
        .box {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 6px;
        }
    </style>
</head>
<body>

    <h1>Courrier Départ</h1>

    <div class="box">
        <div class="row"><span class="label">Numéro :</span> {{ $courrier->numero }}</div>
        <div class="row"><span class="label">Année :</span> {{ $courrier->annee }}</div>
        <div class="row"><span class="label">Objet :</span> {{ $courrier->objet }}</div>
        <div class="row"><span class="label">Type :</span> {{ $courrier->type }}</div>
        <div class="row"><span class="label">Date départ :</span> {{ $courrier->date_depart }}</div>
        <div class="row"><span class="label">Destinataire :</span> {{ $courrier->destinataire_externe }}</div>
        <div class="row"><span class="label">Mode envoi :</span> {{ $courrier->mode_envoi }}</div>
        <div class="row"><span class="label">Nature :</span> {{ $courrier->nature->nom ?? '-' }}</div>
        <div class="row"><span class="label">Description :</span> {{ $courrier->description ?? '-' }}</div>
        <div class="row"><span class="label">Nombre pièces :</span> {{ $courrier->nombre_pieces ?? '-' }}</div>
        <div class="row"><span class="label">Observations :</span> {{ $courrier->observations ?? '-' }}</div>
        <div class="row"><span class="label">Statut :</span> {{ $courrier->status_id == 1 ? 'Draft' : 'Validé' }}</div>
    </div>

</body>
</html>