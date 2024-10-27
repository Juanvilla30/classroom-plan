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
            $table->timestamps();

            // Llaves foraneas
            $table->unsignedBigInteger('id_evaluation');
            $table->foreign('id_evaluation')->references('id')->on('evaluations');
            
            $table->unsignedBigInteger('id_percentage');
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
