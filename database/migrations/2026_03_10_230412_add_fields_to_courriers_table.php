<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up(): void
{

Schema::table('courriers', function (Blueprint $table) {

$table->date('date_arrivee')->nullable()->after('date_courrier');

$table->integer('nombre_pieces')->nullable()->after('destinataire');

$table->text('observations')->nullable()->after('nombre_pieces');

$table->foreignId('nature_id')
->default(1)
->constrained('natures');

});

}

public function down(): void
{

Schema::table('courriers', function (Blueprint $table) {

$table->dropForeign(['nature_id']);
$table->dropColumn('nature_id');

$table->dropColumn('date_arrivee');
$table->dropColumn('nombre_pieces');
$table->dropColumn('observations');

});

}

};