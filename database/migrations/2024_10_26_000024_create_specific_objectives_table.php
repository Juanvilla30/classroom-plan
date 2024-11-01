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
        Schema::create('specific_objectives', function (Blueprint $table) {
            $table->id();
            $table->text('name_specific_objective');
            $table->text('description_specific_objective');
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
        Schema::dropIfExists('specific_objectives');
    }
};
