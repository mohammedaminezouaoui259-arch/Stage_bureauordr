<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
    ];

    //  Status a plusieurs courriers
    public function courriers()
    {
        return $this->hasMany(Courrier::class);
    }
}