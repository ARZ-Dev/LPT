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
        Schema::create('tournament_level_category_teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_level_category_id');
            $table->foreign('tournament_level_category_id', 'fk_tournament_level_category_teams_tournament_level_category')
                ->references('id')
                ->on('tournament_level_categories')
                ->cascadeOnDelete();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_level_category_teams');
    }
};
