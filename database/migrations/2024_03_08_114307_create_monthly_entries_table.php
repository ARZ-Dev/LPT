<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('monthly_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('till_id')->constrained('tills')->cascadeOnDelete();

            $table->date('open_date')->nullable();
            $table->date('close_date')->nullable();
            $table->boolean('pending')->nullable();
            $table->boolean('confirm')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

 
    public function down(): void
    {
        Schema::dropIfExists('monthly_entries');
    }
};
