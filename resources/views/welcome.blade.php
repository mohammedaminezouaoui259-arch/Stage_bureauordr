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
display:flex;
}

/* SIDEBAR */

.sidebar{
width:250px;
background:#0f172a;
color:white;
min-height:100vh;
padding:20px;
}

.sidebar h2{
text-align:center;
font-size:18px;
margin-bottom:20px;
}

.sidebar button{
width:100%;
margin-bottom:10px;
padding:12px;
border:none;
border-radius:8px;
background:#1e293b;
color:white;
cursor:pointer;
transition:0.3s;
}

.sidebar button:hover{
background:#334155;
}

/* 🔥 ADMIN BUTTON */
.admin-btn{
background:#b91c1c !important;
}

.admin-btn:hover{
background:#991b1b !important;
}

/* CONTENT */

.main{
flex:1;
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

/* BUTTONS */

.btn{
padding:12px 28px;
border-radius:8px;
font-weight:600;
color:white;
border:none;
cursor:pointer;
text-decoration:none; /* 🔥 حذف underline */
display:inline-block;
}

.btn-login{
background:#1abc9c;
}

.btn-login:hover{
background:#16a085;
}

/* HERO */

.hero{
text-align:center;
padding:60px 20px;
background:white;
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
margin-bottom:20px;
}

/* CARDS */

.definition{
display:flex;
justify-content:center;
gap:30px;
flex-wrap:wrap;
padding:20px 20px;
margin-top:-40px;
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

.btn-add{
background:#e67e22;
}

.btn-add:hover{
background:#d35400;
}

.btn-list{
background:#3498db;
margin-bottom:10px; /* 🔥 باش يبعدو */
}

.btn-list:hover{
background:#2980b9;
}

/* FOOTER */

.footer{
text-align:center;
padding:25px;
background:#0b3d91;
color:white;
margin-top:40px;
}

</style>
</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

<h2>Gestion Courrier</h2>

<button onclick="window.location.href='/'">
Accueil
</button>

<button onclick="window.location.href='/courriers/create'">
Ajouter Courrier Arrivée
</button>

<button onclick="window.location.href='/courrier-departs/create'">
Ajouter Courrier Départ
</button>

<!-- 🔥 ADMIN (manager + admin) -->
@auth
@if(in_array(auth()->user()->role, ['manager','admin']))
<button onclick="window.location.href='/users'" class="admin-btn">
Administration
</button>
@endif
@endauth

</div>

<!-- MAIN -->

<div class="main">

<!-- HEADER -->

<div class="header">

<div class="header-left">

<img src="{{ asset('images/wilaya (1).png') }}" class="logo">

<div class="title">
Bureau d'Ordre<br>
<small>Conseil Provincial Oujda-Angad</small>
</div>

</div>

<!-- LOGIN / LOGOUT -->

@auth
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="btn btn-login">
Logout
</button>
</form>
@endauth

@guest
<a href="{{ route('login') }}" class="btn btn-login">
Se Connecter
</a>
@endguest

</div>

<!-- HERO -->

<div class="hero">

<h1>Bienvenue sur la Plateforme Bureau d'Ordre</h1>

<p>
Gérez efficacement les courriers entrants et sortants du Conseil Provincial d'Oujda-Angad.
Suivi, archivage sécurisé et accès rapide à tous vos documents administratifs.
</p>

</div>

<!-- CARDS -->

<div class="definition">

<div class="card">

<h3>Courrier Arrivée</h3>

<p>
Enregistrer et suivre tous les courriers entrants dans le bureau d'ordre.
</p>

<a href="/courriers/create" class="btn btn-add">
Ajouter Courrier Arrivée
</a>

</div>

<div class="card">

<h3>Courrier Départ</h3>

<p>
Créer et envoyer des courriers administratifs vers des destinataires externes.
</p>

<a href="/courrier-departs/create" class="btn btn-add">
Ajouter Courrier Départ
</a>

</div>

<div class="card">

<h3>Liste des Courriers</h3>

<p>
Consulter tous les courriers entrants et sortants avec leurs détails.
</p>

<a href="/courriers" class="btn btn-list">
Voir Arrivée
</a>

<a href="/courrier-departs" class="btn btn-list">
Voir Départ
</a>

</div>

</div>

<!-- FOOTER -->

<div class="footer">
© 2026 Conseil de la Province d'Oujda-Angad
</div>

</div>

</body>
</html>