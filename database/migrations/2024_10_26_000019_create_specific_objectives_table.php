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
        Schema::create('specific_objectives', function (Blueprint $table) {
            $table->id();
            $table->text('name_specific_objective');
            $table->text('description_specific_objective');
            $table->timestamps();

            // Llaves foraneas
            $table->unsignedBigInteger('id_topics')->nullable();
            $table->foreign('id_topics')->references('id')->on('topics');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specific_objectives');
    }
};
