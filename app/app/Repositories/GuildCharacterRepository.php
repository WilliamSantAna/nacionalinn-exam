<?php

namespace App\Repositories;

use App\Models\{GuildCharacter, Guild, Player};
use App\Interfaces\GuildCharacterRepositoryInterface;

class GuildCharacterRepository implements GuildCharacterRepositoryInterface
{
    public function getAllGuildCharacters()
    {
        return GuildCharacter::all();
    }

    public function getGuildCharacterById($id)
    {
        return GuildCharacter::find($id);
    }

    public function createGuildCharacter(array $data)
    {
        return GuildCharacter::create($data);
    }

    public function updateGuildCharacter($id, array $data)
    {
        $guildCharacter = GuildCharacter::find($id);
        if ($guildCharacter) {
            $guildCharacter->update($data);
            return $guildCharacter;
        }
        return null;
    }

    public function deleteGuildCharacter($id)
    {
        $guildCharacter = GuildCharacter::find($id);
        if ($guildCharacter) {
            $guildCharacter->delete();
            return true;
        }
        return false;
    }

    public function getGuildCharactersByGuild($guildId)
    {
        return GuildCharacter::where('guild_id', $guildId)->get();
    }

    public function getCharactersByPlayer($playerId)
    {
        $guild = Guild::where('player_id', $playerId)->first();
        if ($guild) {
            return $guild->characters;
        }
        return null;
    }

    public function addCharacterToGuild($guildId, $characterId)
    {
        return GuildCharacter::create([
            'guild_id' => $guildId,
            'character_id' => $characterId
        ]);
    }

    public function removeCharacterFromGuild($guildId, $characterId)
    {
        $guildCharacter = GuildCharacter::where('guild_id', $guildId)
            ->where('character_id', $characterId)
            ->first();

        if ($guildCharacter) {
            $guildCharacter->delete();
            return true;
        }
        return false;
    }

    public function getGuildByPlayerId($playerId)
    {
        return Guild::where('player_id', $playerId)->first();
    }

    public function getCharactersByGuild($guildId)
    {
        $guild = Guild::find($guildId);
        return $guild ? $guild->characters : null;
    }    
}
