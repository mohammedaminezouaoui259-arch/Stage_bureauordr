<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courrier_departs', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->default(1)->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('courrier_departs', function (Blueprint $table) {
            $table->dropColumn('status_id');
        });
    }
};