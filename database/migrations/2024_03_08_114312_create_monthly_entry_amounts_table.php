<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('monthly_entry_amounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monthly_entry_id')->constrained('monthly_entries')->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained('currencies')->cascadeOnDelete();
            $table->double('amount');
            $table->double('closing_amount');
            $table->softDeletes();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('monthly_entry_amounts');
    }
};
