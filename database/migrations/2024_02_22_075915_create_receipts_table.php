<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('till_id')->constrained('tills')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('paid_by');
            $table->string('description')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
