<?php

namespace App\Repositories;

use App\Models\Guild;
use App\Interfaces\GuildRepositoryInterface;

class GuildRepository implements GuildRepositoryInterface
{
    public function getAllGuilds()
    {
        return Guild::all();
    }

    public function getGuildById($id)
    {
        return Guild::find($id);
    }

    public function createGuild(array $data)
    {
        return Guild::create($data);
    }

    public function updateGuild($id, array $data)
    {
        $guild = Guild::find($id);
        if ($guild) {
            $guild->update($data);
            return $guild;
        }
        return null;
    }

    public function deleteGuild($id)
    {
        $guild = Guild::find($id);
        if ($guild) {
            $guild->delete();
            return true;
        }
        return false;
    }

    public function getGuildByPlayerId($playerId)
    {
        return Guild::where('player_id', $playerId)->first();
    }
}
