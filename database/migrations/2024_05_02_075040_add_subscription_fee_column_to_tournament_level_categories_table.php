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
        Schema::table('tournament_level_categories', function (Blueprint $table) {
            $table->double('subscription_fee')->nullable()->after('level_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournament_level_categories', function (Blueprint $table) {
            $table->dropColumn('subscription_fee');
        });
    }
};
