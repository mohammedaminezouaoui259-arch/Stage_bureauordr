<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nature extends Model
{

protected $fillable = [
'nom'
];

public function courriers()
{
return $this->hasMany(Courrier::class);
}

}