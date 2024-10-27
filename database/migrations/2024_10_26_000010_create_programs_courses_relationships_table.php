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
        Schema::create('programs_courses_relationships', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Llaves foráneas
            $table->unsignedBigInteger('id_program');
            $table->foreign('id_program')->references('id')->on('programs');

            $table->unsignedBigInteger('id_course');
            $table->foreign('id_course')->references('id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs_courses_relationships');
    }
};
