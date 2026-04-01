<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$users = DB::table('users')->get(['name', 'email', 'role', 'service']);
foreach ($users as $u) {
    echo $u->name.' | '.$u->email.' | '.$u->role.' | '.($u->service ?? '-').PHP_EOL;
}
