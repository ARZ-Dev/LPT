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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->foreignId('group_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('knockout_round_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('home_team_id')->nullable()->constrained('teams')->cascadeOnDelete();
            $table->foreignId('away_team_id')->nullable()->constrained('teams')->cascadeOnDelete();
            $table->foreignId('related_home_game_id')->nullable()->constrained('games')->nullOnDelete();
            $table->foreignId('related_away_game_id')->nullable()->constrained('games')->nullOnDelete();
            $table->dateTime('datetime')->nullable();
            $table->foreignId('winner_team_id')->nullable()->constrained('teams')->cascadeOnDelete();
            $table->foreignId('loser_team_id')->nullable()->constrained('teams')->cascadeOnDelete();
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
