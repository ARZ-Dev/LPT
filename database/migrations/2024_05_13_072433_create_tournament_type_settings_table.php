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
        Schema::create('tournament_type_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_type_id')->constrained()->cascadeOnDelete();
            $table->string('stage');
            $table->string('points');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_type_settings');
    }
};
