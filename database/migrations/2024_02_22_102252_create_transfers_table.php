<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_till_id')->constrained('tills')->cascadeOnDelete();
            $table->foreignId('to_till_id')->constrained('tills')->cascadeOnDelete();
            $table->double('usd_amount')->nullable();
            $table->double('lbp_amount')->nullable();


            $table->softDeletes();
            $table->timestamps();
        });
    }

 
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
