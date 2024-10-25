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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_course');
            $table->unsignedBigInteger('id_profiles_competencies_ra')->nullable();
            $table->unsignedBigInteger('id_general_objective')->nullable();
            $table->unsignedBigInteger('id_specific_objective')->nullable();
            $table->unsignedBigInteger('id_general_reference')->nullable();
            $table->unsignedBigInteger('id_institutional_reference')->nullable();
            $table->unsignedBigInteger('id_assignment_evaluation')->nullable();
            $table->unsignedBigInteger('id_update_histories')->nullable();
            $table->timestamps();

            //LLaves foraneas
            $table->foreign('id_course')->references('id')->on('courses');
            $table->foreign('id_profiles_competencies_ra')->references('id')->on('profiles_competencies_ra');
            $table->foreign('id_general_objective')->references('id')->on('general_objective');
            $table->foreign('id_specific_objective')->references('id')->on('specific_objectives');
            $table->foreign('id_general_reference')->references('id')->on('general_references');
            $table->foreign('id_institutional_reference')->references('id')->on('institutional_references');
            $table->foreign('id_assignment_evaluation')->references('id')->on('assignments_evaluations');
            $table->foreign('id_update_histories')->references('id')->on('update_histories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
