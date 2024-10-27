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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('name_evaluation');
            $table->string('description')->nullable();
            $table->timestamps();

            // Llaves foraneas
            $table->unsignedBigInteger('id_course_type');
            $table->foreign('id_course_type')->references('id')->on('course_types');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
