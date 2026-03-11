<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courrier extends Model
{

use HasFactory;

protected $fillable = [

'numero',
'annee',
'type',
'objet',
'description',
'date_courrier',
'date_arrivee',
'expediteur',
'destinataire',
'nombre_pieces',
'observations',
'fichier',
'nature_id',
'status_id',
'user_id'

];


// relation user
public function user()
{
return $this->belongsTo(User::class);
}


// relation status
public function status()
{
return $this->belongsTo(Status::class);
}


// relation nature
public function nature()
{
return $this->belongsTo(Nature::class);
}


// affectations
public function affectations()
{
return $this->hasMany(Affectation::class);
}


// traitements
public function traitements()
{
return $this->hasMany(Traitement::class);
}


// archive
public function archive()
{
return $this->hasOne(Archive::class);
}

}