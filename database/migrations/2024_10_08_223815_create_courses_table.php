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
            $table->string('name_curse');
            $table->integer('credit');
            $table->unsignedBigInteger('id_modalitie');
            $table->unsignedBigInteger('id_program');
            $table->unsignedBigInteger('id_component');
            $table->unsignedBigInteger('id_semester');
            $table->unsignedBigInteger('id_type_course');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->timestamps();

            //LLaves foraneas
            $table->foreign('id_modalitie')->references('id')->on('modalities');
            $table->foreign('id_program')->references('id')->on('roles');
            $table->foreign('id_component')->references('id')->on('components');
            $table->foreign('id_semester')->references('id')->on('semesters');
            $table->foreign('id_type_course')->references('id')->on('types_courses');
            $table->foreign('id_user')->references('id')->on('users');
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
