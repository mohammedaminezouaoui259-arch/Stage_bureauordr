<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<style>

body{
font-family: DejaVu Sans, sans-serif;
}

h1{
text-align:center;
margin-bottom:30px;
}

table{
width:100%;
border-collapse:collapse;
}

td{
border:1px solid black;
padding:8px;
}

</style>

</head>

<body>

<h1>Formulaire Courrier</h1>

<table>

<tr>
<td><strong>Numero</strong></td>
<td>{{ $courrier->numero }}</td>
</tr>

<tr>
<td><strong>Objet</strong></td>
<td>{{ $courrier->objet }}</td>
</tr>

<tr>
<td><strong>Type</strong></td>
<td>{{ $courrier->type }}</td>
</tr>

<tr>
<td><strong>Date</strong></td>
<td>{{ $courrier->date_courrier }}</td>
</tr>

<tr>
<td><strong>Expediteur</strong></td>
<td>{{ $courrier->expediteur }}</td>
</tr>

<tr>
<td><strong>Destinataire</strong></td>
<td>{{ $courrier->destinataire }}</td>
</tr>

<tr>
<td><strong>Description</strong></td>
<td>{{ $courrier->description }}</td>
</tr>

</table>

</body>

</html>