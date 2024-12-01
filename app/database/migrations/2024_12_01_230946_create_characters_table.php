<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->enum('archetype', ['Warrior', 'Mage', 'Archer', 'Cleric']);  // Tipo de personagem
            $table->integer('xp')->unsigned()->default(1);  // XP com valor padrão 1
            $table->unsignedBigInteger('guild_id');  // Relacionamento com a Guild
            $table->timestamps();
    
            // Chave estrangeira para guilds
            $table->foreign('guild_id')->references('id')->on('guilds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
