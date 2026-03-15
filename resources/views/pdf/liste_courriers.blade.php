<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<style>

body{
font-family: DejaVu Sans;
}

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

th,td{
border:1px solid #000;
padding:6px;
text-align:center;
font-size:12px;
}

h2{
text-align:center;
}

</style>

</head>

<body>

<h2>Liste Courrier Année {{ $annee }}</h2>

<table>

<thead>

<tr>
<th>Numero</th>
<th>Objet</th>
<th>Date</th>
<th>Service</th>
</tr>

</thead>

<tbody>

@foreach($courriers as $c)

<tr>

<td>{{ $c->numero }}</td>

<td>{{ $c->objet }}</td>

<td>{{ $c->date_arrivee }}</td>

<td>

{{ $c->affectations[0]->service->nom_service ?? '-' }}

</td>

</tr>

@endforeach

</tbody>

</table>

</body>
</html>