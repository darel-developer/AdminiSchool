<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id'); // Référence à l'enseignant
            $table->unsignedBigInteger('tuteur_id');  // Référence au tuteur
            $table->text('message');                 // Contenu du message
            $table->timestamps();

            // Clés étrangères
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('tuteur_id')->references('id')->on('tuteurs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
