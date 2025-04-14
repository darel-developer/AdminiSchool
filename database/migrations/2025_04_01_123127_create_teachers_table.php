<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('subject'); // Matière enseignée
            $table->string('type')->default('teacher'); // Type par défaut : teacher
            $table->string('password');
            $table->unsignedBigInteger('class_id'); // Référence à la classe
            $table->timestamps();

            // Clé étrangère pour la classe
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('teachers');
    }
}
