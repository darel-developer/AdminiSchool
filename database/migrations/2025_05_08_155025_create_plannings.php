<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plannings', function (Blueprint $table) {
            $table->id();
            $table->string('class');
            $table->date('date');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('code');
            $table->string('teacher');
            $table->string('room');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plannings');
    }
};