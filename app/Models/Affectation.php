<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    protected $fillable = [
        'date_affectation',
        'courrier_id',
        'service_id',
    ];

    public function courrier()
    {
        return $this->belongsTo(Courrier::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}