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
        Schema::create('profiles_competencies_ra', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_profile_graduation');
            $table->unsignedBigInteger('id_competencies');
            $table->unsignedBigInteger('id_learning_result');
            $table->unsignedBigInteger('id_program');
            $table->timestamps();

            //LLaves foraneas
            $table->foreign('id_profile_graduation')->references('id')->on('profile_graduation');
            $table->foreign('id_competencies')->references('id')->on('competencies');
            $table->foreign('id_learning_result')->references('id')->on('learning_results');
            $table->foreign('id_program')->references('id')->on('programs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles_competencies_ra');
    }
};
