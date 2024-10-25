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
            $table->unsignedBigInteger('id_topic');
            $table->timestamps();

            //LLaves foraneas
            $table->foreign('id_topic')->references('id')->on('topics');
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
