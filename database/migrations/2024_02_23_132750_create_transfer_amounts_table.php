<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('transfer_amounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_id')->constrained('transfers')->cascadeOnDelete();
            $table->double('amount');
            $table->foreignId('currency_id')->constrained('currencies')->cascadeOnDelete();

            $table->softDeletes();
            $table->timestamps();
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('transfer_amounts');
    }
};
