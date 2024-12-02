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
        Schema::table('guilds', function (Blueprint $table) {
            $table->dropForeign(['campaign_id']);
            $table->dropColumn('campaign_id');
            $table->unsignedBigInteger('player_id');
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guilds', function (Blueprint $table) {
            //
        });
    }
};
