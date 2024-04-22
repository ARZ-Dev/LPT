<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::table('knockout_stages', function (Blueprint $table) {

            $table->foreignId('tournament_deuce_type_id')->after('tournament_level_category_id')->nullable()->constrained('tournament_deuce_types')->cascadeOnDelete();
            $table->integer('nb_of_sets')->after('name')->nullable();
            $table->integer('nb_of_games')->after('nb_of_sets')->nullable();
            $table->integer('tie_break')->after('nb_of_games')->nullable();

        });
     
    }

    public function down(): void
    {
        Schema::table('knockout_stages', function (Blueprint $table) {
            $table->dropColumn('tournament_deuce_type_id');
            $table->dropColumn('nb_of_sets');
            $table->dropColumn('nb_of_games');
            $table->dropColumn('tie_break');

        });
    }
};
