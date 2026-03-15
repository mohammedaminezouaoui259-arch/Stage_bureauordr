<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourrierDepart extends Model
{
    use HasFactory;

    protected $table = 'courrier_departs';

    protected $fillable = [
        'numero',
        'annee',
        'objet',
        'type',
        'date_depart',
        'destinataire_externe',
        'mode_envoi',
        'description',
        'nombre_pieces',
        'observations',
        'fichier',
        'nature_id',
        'courrier_arrive_id',
        'user_id',
        'status_id'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    // relation avec nature
    public function nature()
    {
        return $this->belongsTo(Nature::class);
    }

    // relation avec courrier arrivé (réponse à)
    public function courrierArrive()
    {
        return $this->belongsTo(Courrier::class, 'courrier_arrive_id');
    }

    // relation avec user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}