<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('acteur', function (Blueprint $table) {
            $table->id();
            $table->string('firstName')->nullable();
            $table->string('secondName')->nullable();
            $table->string('accountType');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('childName')->nullable();
            $table->string('SchoolName')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acteur');
    }
};