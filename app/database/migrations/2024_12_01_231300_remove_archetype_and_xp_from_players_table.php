<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveArchetypeAndXpFromPlayersTable extends Migration
{
    public function up()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn('archetype');
            $table->dropColumn('xp');
        });
    }

    public function down()
    {
        //
    }
}
