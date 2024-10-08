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
        Schema::table('players', function (Blueprint $table) {
            $table->after('playing_side', function ($table) {
                $table->string('gender')->nullable();
                $table->integer('matches')->default(0);
                $table->integer('wins')->default(0);
                $table->integer('losses')->default(0);
                $table->integer('rank')->default(1);
                $table->integer('points')->default(0);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('matches');
            $table->dropColumn('wins');
            $table->dropColumn('losses');
            $table->dropColumn('rank');
            $table->dropColumn('points');
        });
    }
};
