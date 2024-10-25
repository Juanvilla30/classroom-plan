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
        Schema::create('assignments_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_evaluation');
            $table->unsignedBigInteger('id_percentage');
            $table->timestamps();

            //LLaves foraneas
            $table->foreign('id_evaluation')->references('id')->on('evaluations');
            $table->foreign('id_percentage')->references('id')->on('percentages');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments_evaluations');
    }
};
