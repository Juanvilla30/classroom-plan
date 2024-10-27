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
        Schema::create('profiles_egress', function (Blueprint $table) {
            $table->id();
            $table->text('name_profile_egres');
            $table->timestamps();

            // Llaves foraneas
            $table->unsignedBigInteger('id_program');
            $table->foreign('id_program')->references('id')->on('programs');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles_egress');
    }
};
