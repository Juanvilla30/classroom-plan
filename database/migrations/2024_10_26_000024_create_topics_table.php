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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->text('description_topic');
            $table->timestamps();

            // Llaves foraneas
            $table->unsignedBigInteger('id_specific_objective')->nullable();
            $table->foreign('id_specific_objective')->references('id')->on('specific_objectives');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
