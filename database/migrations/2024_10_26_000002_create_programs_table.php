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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->integer('code_program');
            $table->string('name_program');
            $table->integer('anio');
            $table->string('degree_type');
            $table->timestamps();

            // Llaves foraneas
            $table->unsignedBigInteger('id_role')->nullable();
            $table->foreign('id_role')->references('id')->on('roles');

            $table->unsignedBigInteger('id_education_level')->nullable(); 
            $table->foreign('id_education_level')->references('id')->on('education_levels');
            
            $table->unsignedBigInteger('id_faculty')->nullable();
            $table->foreign('id_faculty')->references('id')->on('faculties');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
