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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('archetype', ['Warrior', 'Mage', 'Archer', 'Cleric']); // Classes
            $table->integer('xp')->unsigned()->default(1); // XP entre 1 a 100
            $table->boolean('confirmed')->default(false); // Se o jogador está confirmado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
