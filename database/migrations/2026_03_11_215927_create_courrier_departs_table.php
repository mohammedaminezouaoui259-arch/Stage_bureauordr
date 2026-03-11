<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
Schema::create('courrier_departs', function (Blueprint $table) {

$table->id();

$table->string('numero'); // numéro départ auto
$table->integer('annee');

$table->string('objet');

$table->string('type');

$table->date('date_depart');

$table->string('destinataire_externe');

$table->string('mode_envoi'); // Poste / Email / Remise main propre

$table->text('description')->nullable();

$table->integer('nombre_pieces')->nullable();

$table->text('observations')->nullable();

$table->string('fichier')->nullable();

$table->foreignId('nature_id')
->default(1)
->constrained('natures');

$table->foreignId('courrier_arrive_id')
->nullable()
->constrained('courriers')
->nullOnDelete();

$table->foreignId('user_id')->constrained()->cascadeOnDelete();

$table->timestamps();

});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courrier_departs');
    }
};
