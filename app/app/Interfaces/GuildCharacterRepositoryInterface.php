<?php

namespace App\Interfaces;

interface GuildCharacterRepositoryInterface
{
    public function getAllGuildCharacters();
    public function getGuildCharacterById($id);
    public function createGuildCharacter(array $data);
    public function updateGuildCharacter($id, array $data);
    public function deleteGuildCharacter($id);
    public function getGuildCharactersByGuild($guildId);
    public function getCharactersByPlayer($playerId);
    public function addCharacterToGuild($guildId, $characterId);
    public function removeCharacterFromGuild($guildId, $characterId);
    public function getGuildByPlayerId($playerId);
    public function getCharactersByGuild($guildId);
}
