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
        Schema::create('histories_classroom_plans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Llaves foraneas
            $table->unsignedBigInteger('id_classroom_plan');
            $table->foreign('id_classroom_plan')->references('id')->on('classroom_plans');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories_classroom_plans');
    }
};
