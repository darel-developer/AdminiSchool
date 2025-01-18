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
        Schema::table('acteur', function (Blueprint $table) {
            $table->string('childName')->nullable();
            $table->string('SchoolName')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('acteur', function (Blueprint $table) {
            $table->dropColumn(['childName', 'SchoolName']);
        });
    }
};
