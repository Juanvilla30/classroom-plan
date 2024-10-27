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
        Schema::create('competences', function (Blueprint $table) {
            $table->id();
            $table->text('name_competence');
            $table->text('description_competence');
            $table->timestamps();

            // Llaves foraneas
            $table->unsignedBigInteger('id_profile_egres');
            $table->foreign('id_profile_egres')->references('id')->on('profiles_egress');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competences');
    }
};
