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
        Schema::table('messages', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('tuteur_id');
            $table->unsignedBigInteger('student_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('tuteur_id')->references('id')->on('tuteurs')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
           Schema::dropIfExists('messages');
        });
    }
};
