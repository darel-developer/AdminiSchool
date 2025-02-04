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
        Schema::table('paiements', function (Blueprint $table) {
            $table->dropForeign(['tuteur_id']); // Drop the foreign key constraint
            $table->dropColumn('tuteur_id'); // Drop the column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paiements', function (Blueprint $table) {
            $table->unsignedBigInteger('tuteur_id')->nullable();
            $table->foreign('tuteur_id')->references('id')->on('tuteurs')->onDelete('cascade');
        });
    }
};
