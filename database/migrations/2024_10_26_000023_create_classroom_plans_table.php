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
            $table->timestamps();

            // Llaves foraneas
            $table->unsignedBigInteger('id_course');
            $table->foreign('id_course')->references('id')->on('courses');

            $table->unsignedBigInteger('id_assignment_evaluation')->nullable();
            $table->foreign('id_assignment_evaluation')->references('id')->on('assignments_evaluations');

            $table->unsignedBigInteger('id_learning_result')->nullable();
            $table->foreign('id_learning_result')->references('id')->on('learning_results');

            $table->unsignedBigInteger('id_general_objective')->nullable();
            $table->foreign('id_general_objective')->references('id')->on('general_objectives');

            $table->unsignedBigInteger('id_specific_objective')->nullable();
            $table->foreign('id_specific_objective')->references('id')->on('specific_objectives');

            $table->unsignedBigInteger('id_reference')->nullable();
            $table->foreign('id_reference')->references('id')->on('references');

            $table->unsignedBigInteger('id_state');
            $table->foreign('id_state')->references('id')->on('states');

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
