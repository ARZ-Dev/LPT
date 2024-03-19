<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->text('paid_to')->after('sub_category_id')->nullable();
        });
    }

  
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('paid_to');           
        });
    }
};
