<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tuteur_id');
            $table->string('file_path');
            $table->string('type')->nullable();
            $table->timestamps();

            $table->foreign('tuteur_id')->references('id')->on('tuteurs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};

