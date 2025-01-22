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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom de l'élève
            $table->date('enrollment_date'); // Date d'inscription
            $table->integer('absences')->default(0); // Nombre d'absences
            $table->integer('warnings')->default(0); // Nombre d'interpellations
            $table->string('class'); // Classe
            $table->integer('convocations')->default(0); // Nombre de convocations
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
