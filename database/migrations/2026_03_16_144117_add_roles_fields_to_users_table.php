<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // role: admin / manager / user
            $table->string('role')->default('user')->after('password');

            // service (service dyal manager)
            $table->string('service')->nullable()->after('role');

            // actif ou non
            $table->boolean('is_active')->default(true)->after('service');

            // nature (ila bghaha ostad)
            $table->unsignedBigInteger('nature_id')->nullable()->after('is_active');

            $table->foreign('nature_id')
                ->references('id')
                ->on('natures')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['nature_id']);

            $table->dropColumn([
                'role',
                'service',
                'is_active',
                'nature_id'
            ]);
        });
    }
};