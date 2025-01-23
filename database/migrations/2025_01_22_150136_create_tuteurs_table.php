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
        Schema::create('tuteurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');             // Champ 'firstName'
            $table->string('prenom');          // Champ 'secondName'
            $table->string('email')->unique(); // Champ 'username'
            $table->string('password');        // Champ 'password'
            $table->string('type');            // Champ 'type' (par exemple 'parent')
            $table->string('childName');       // Champ 'childName'
            $table->string('schoolName')->nullable(); // Champ 'schoolName'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tuteurs');
    }
};
