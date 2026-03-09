<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_service',
        'description',
    ];

    /* =====================
       RELATIONS
    ====================== */

    //  Service peut recevoir plusieurs affectations
    public function affectations()
    {
        return $this->hasMany(Affectation::class);
    }

    //  Service peut effectuer plusieurs traitements
    public function traitements()
    {
        return $this->hasMany(Traitement::class);
    }
}