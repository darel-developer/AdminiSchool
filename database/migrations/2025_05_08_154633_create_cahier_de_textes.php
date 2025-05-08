<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cahier_de_textes', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('matiere');
            $table->text('contenu');
            $table->string('professeur');
            $table->text('devoirs')->nullable();
            $table->string('class');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cahier_de_textes');
    }
};