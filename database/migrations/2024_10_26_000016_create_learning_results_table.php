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
        Schema::create('learning_results', function (Blueprint $table) {
            $table->id();
            $table->text('name_learning_result');
            $table->text('description_learning_result');

            // Llaves foraneas
            $table->unsignedBigInteger('id_competence');
            $table->foreign('id_competence')->references('id')->on('competences');

            // CAMPOS DE ACTUALIZACION
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_results');
    }
};
