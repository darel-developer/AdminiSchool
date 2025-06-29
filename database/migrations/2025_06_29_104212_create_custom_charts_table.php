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
        Schema::create('custom_charts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('type')->default('bar');
            $table->json('labels');
            $table->json('datasets');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_charts');
    }
};
