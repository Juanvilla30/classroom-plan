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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_code');
            $table->string('name_course');
            $table->integer('credit');
            $table->integer('pretential_time')->nullable();
            $table->integer('independent_time')->nullable();    

            // Llaves foráneas
            $table->unsignedBigInteger('id_modality')->nullable();
            $table->foreign('id_modality')->references('id')->on('modalities');

            $table->unsignedBigInteger('id_component')->nullable();
            $table->foreign('id_component')->references('id')->on('components');

            $table->unsignedBigInteger('id_semester');
            $table->foreign('id_semester')->references('id')->on('semesters');

            $table->unsignedBigInteger('id_course_type');
            $table->foreign('id_course_type')->references('id')->on('course_types');
            
            $table->unsignedBigInteger('id_user')->nullable(); 
            $table->foreign('id_user')->references('id')->on('users');

            // CAMPOS DE ACTUALIZACION
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
