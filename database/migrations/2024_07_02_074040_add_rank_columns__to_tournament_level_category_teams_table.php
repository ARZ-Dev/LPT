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
        Schema::table('tournament_level_category_teams', function (Blueprint $table) {
            $table->string('last_rank')->nullable()->after('players_ids');
            $table->string('score')->nullable()->after('last_rank');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournament_level_category_teams', function (Blueprint $table) {
            $table->dropColumn(['last_rank', 'score']);
        });
    }
};
