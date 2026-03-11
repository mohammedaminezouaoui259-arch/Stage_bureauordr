<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Nature;

class NatureController extends Controller
{

public function index()
{

return response()->json(
Nature::all()
);

}

}