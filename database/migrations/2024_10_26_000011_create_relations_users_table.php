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
        Schema::create('relations_users', function (Blueprint $table) {
            $table->id();

            // Llaves foráneas
            $table->unsignedBigInteger('id_relation')->nullable();
            $table->foreign('id_relation')->references('id')->on('programs_courses_relationships');

            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relations_users');
    }
};
