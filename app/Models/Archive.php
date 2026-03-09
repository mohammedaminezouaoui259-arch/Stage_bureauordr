<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_archivage',
        'emplacement',
        'courrier_id',
    ];

    //  Archive appartient à un courrier
    public function courrier()
    {
        return $this->belongsTo(Courrier::class);
    }
}