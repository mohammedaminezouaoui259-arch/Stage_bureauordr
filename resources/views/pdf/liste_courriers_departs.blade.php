<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste Courriers Départs</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: center;
        }
        th {
            background: #e5e5e5;
        }
    </style>
</head>
<body>

    <h1>Liste des Courriers Départs - {{ $annee }}</h1>

    <table>
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Année</th>
                <th>Objet</th>
                <th>Date départ</th>
                <th>Destinataire</th>
                <th>Mode envoi</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courriers as $courrier)
                <tr>
                    <td>{{ $courrier->numero }}</td>
                    <td>{{ $courrier->annee }}</td>
                    <td>{{ $courrier->objet }}</td>
                    <td>{{ $courrier->date_depart }}</td>
                    <td>{{ $courrier->destinataire_externe }}</td>
                    <td>{{ $courrier->mode_envoi }}</td>
                    <td>{{ $courrier->status_id == 1 ? 'Draft' : 'Validé' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Aucun courrier départ trouvé</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>