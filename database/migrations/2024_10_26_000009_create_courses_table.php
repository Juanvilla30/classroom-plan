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
            $table->string('name_course');
            $table->integer('credit');
            $table->timestamps();

            // Llaves foráneas
            $table->unsignedBigInteger('id_modality');
            $table->foreign('id_modality')->references('id')->on('modalities');

            $table->unsignedBigInteger('id_component'); // Corrección en el nombre del campo
            $table->foreign('id_component')->references('id')->on('components');

            $table->unsignedBigInteger('id_semester');
            $table->foreign('id_semester')->references('id')->on('semesters');

            $table->unsignedBigInteger('id_course_type');
            $table->foreign('id_course_type')->references('id')->on('course_types');

            $table->unsignedBigInteger('id_role')->nullable(); // Corrección en el nombre del campo
            $table->foreign('id_role')->references('id')->on('roles');
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
