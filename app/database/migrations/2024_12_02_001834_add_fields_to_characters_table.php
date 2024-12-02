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
        Schema::table('characters', function (Blueprint $table) {
            $table->integer('hp')->unsigned()->default(1);  // Pontos de vida
            $table->integer('mp')->unsigned()->default(1);  // Pontos de magia
            $table->integer('at')->unsigned()->default(1);  // Pontos de ataque
            $table->integer('df')->unsigned()->default(1);  // Pontos de defesa
            $table->integer('qa')->unsigned()->default(1);  // Quantidade de ataques
            $table->integer('in')->unsigned()->default(1);  // Pontos de iniciativa
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropColumn('hp');
            $table->dropColumn('mp');
            $table->dropColumn('at');
            $table->dropColumn('df');
            $table->dropColumn('qa');
            $table->dropColumn('in');
        });
    }
};
