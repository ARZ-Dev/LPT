<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('till_amounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('till_id')->constrained('tills')->cascadeOnDelete();
            $table->double('amount');
            $table->foreignId('currency_id')->constrained('currencies')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('till_amounts');
    }
};
