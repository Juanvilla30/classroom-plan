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
        Schema::create('classroom_plans', function (Blueprint $table) {
            $table->id();

            // Llaves foraneas
            $table->unsignedBigInteger('id_relations');
            $table->foreign('id_relations')->references('id')->on('programs_courses_relationships');

            $table->unsignedBigInteger('id_learning_result')->nullable();
            $table->foreign('id_learning_result')->references('id')->on('learning_results');

            $table->unsignedBigInteger('id_general_objective')->nullable();
            $table->foreign('id_general_objective')->references('id')->on('general_objectives');

            $table->unsignedBigInteger('id_state');
            $table->foreign('id_state')->references('id')->on('states');

            // CAMPOS DE ACTUALIZACION
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classroom_plans');
    }
};
