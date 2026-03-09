```html
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Bureau d'Ordre - Conseil Provincial Oujda-Angad</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>

body{
margin:0;
font-family:'Poppins',sans-serif;
background:#f4f6f9;
color:#333;
}

/* HEADER */

.header{
display:flex;
justify-content:space-between;
align-items:center;
padding:20px 50px;
background:#0b3d91;
color:white;
box-shadow:0 3px 10px rgba(0,0,0,0.1);
}

.header-left{
display:flex;
align-items:center;
gap:15px;
}

.logo{
height:60px;
}

.title{
font-weight:600;
font-size:22px;
line-height:1.2;
}

/* HERO */

.hero{
text-align:center;
padding:110px 20px;
background:white;
border-bottom:4px solid #0b3d91;
}

.hero h1{
font-size:42px;
margin-bottom:20px;
color:#0b3d91;
}

.hero p{
font-size:18px;
max-width:700px;
margin:auto;
line-height:1.6;
margin-bottom:35px;
}

/* BUTTONS */

.btn{
display:inline-block;
padding:12px 28px;
border-radius:8px;
font-weight:600;
text-decoration:none;
color:white;
transition:0.3s;
}

.btn-login{
background:#1abc9c;
}

.btn-login:hover{
background:#16a085;
}

.btn-add{
background:#e67e22;
}

.btn-add:hover{
background:#d35400;
}

.btn-list{
background:#3498db;
}

.btn-list:hover{
background:#2980b9;
}

/* CARDS */

.definition{
display:flex;
justify-content:center;
gap:30px;
flex-wrap:wrap;
padding:60px 20px;
}

.card{
background:white;
padding:30px;
border-radius:12px;
width:300px;
box-shadow:0 8px 20px rgba(0,0,0,0.05);
text-align:center;
transition:0.3s;
}

.card:hover{
transform:translateY(-8px);
box-shadow:0 12px 25px rgba(0,0,0,0.1);
}

.card h3{
margin-bottom:12px;
color:#0b3d91;
}

.card p{
font-size:16px;
color:#555;
margin-bottom:20px;
}

/* FOOTER */

.footer{
text-align:center;
padding:25px;
background:#0b3d91;
color:white;
margin-top:40px;
}

/* RESPONSIVE */

@media(max-width:900px){

.definition{
flex-direction:column;
align-items:center;
}

.hero h1{
font-size:32px;
}

}

</style>
</head>

<body>

<!-- HEADER -->

<div class="header">

<div class="header-left">

<img src="{{ asset('images/wilaya (1).png') }}" class="logo">

<div class="title">
Bureau d'Ordre<br>
<small>Conseil Provincial Oujda-Angad</small>
</div>

</div>

<a href="{{ route('login') }}" class="btn btn-login">
Se Connecter
</a>

</div>

<!-- HERO -->

<div class="hero">

<h1>Bienvenue sur la Plateforme Bureau d'Ordre</h1>

<p>
Gérez efficacement les courriers entrants et sortants du Conseil Provincial d'Oujda-Angad.
Suivi, archivage sécurisé et accès rapide à tous vos documents administratifs.
</p>

<a href="/courriers/create" class="btn btn-add">
Ajouter un Courrier
</a>

&nbsp;

<a href="/courriers" class="btn btn-list">
Voir la Liste des Courriers
</a>

</div>

<!-- CARDS -->

<div class="definition">

<div class="card">

<h3>Gestion des Courriers</h3>

<p>
Suivi complet des courriers entrants et sortants avec une gestion simplifiée.
</p>

<a href="/courriers" class="btn btn-list">
Accéder à la Liste
</a>

</div>

<div class="card">

<h3>Archivage Sécurisé</h3>

<p>
Tous les documents sont archivés numériquement pour un accès rapide et sécurisé.
</p>

<a href="/courriers/create" class="btn btn-add">
Ajouter un Courrier
</a>

</div>

</div>

<!-- FOOTER -->

<div class="footer">
© 2026 Conseil de la Province d'Oujda-Angad
</div>

</body>
</html>
```