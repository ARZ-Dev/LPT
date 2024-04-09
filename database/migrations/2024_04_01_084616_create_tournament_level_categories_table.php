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
        Schema::create('tournament_level_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
            $table->foreignId('level_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tournament_type_id')->nullable()->constrained()->cascadeOnDelete();
            $table->integer('number_of_teams')->nullable();
            $table->boolean('has_group_stage')->default(false);
            $table->integer('number_of_groups')->nullable();
            $table->integer('number_of_winners_per_group')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_group_matches_generated')->default(false);
            $table->boolean('is_knockout_matches_generated')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_level_categories');
    }
};
