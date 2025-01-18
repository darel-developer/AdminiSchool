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
        Schema::create('acteur', function (Blueprint $table) {
            $table->id();
            $table->string('firstName')->nullable(); // Prénom
            $table->string('secondName')->nullable(); // Nom de famille
            $table->string('accountType'); // Type de compte (e.g., parent, teacher, etc.)
            $table->string('username')->unique(); // Nom d'utilisateur unique
            $table->string('password'); // Mot de passe (haché)
            $table->string('childName')->nullable(); // Nom de l'enfant (pour les parents uniquement)
            $table->string('SchoolName')->nullable(); // Nom de l'école
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acteur');
    }
};
