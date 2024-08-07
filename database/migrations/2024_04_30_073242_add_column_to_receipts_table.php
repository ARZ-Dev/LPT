<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->foreignId('tournament_id')->after('sub_category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('team_id')->after('tournament_id')->nullable()->constrained()->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropForeign(['tournament_id']);
            $table->dropForeign(['team_id']);
            $table->dropColumn('tournament_id');
            $table->dropColumn('team_id');
        });
    }
};
