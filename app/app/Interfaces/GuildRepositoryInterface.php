<?php

namespace App\Interfaces;

interface GuildRepositoryInterface
{
    public function getAllGuilds();
    public function getGuildById($id);
    public function createGuild(array $data);
    public function updateGuild($id, array $data);
    public function deleteGuild($id);
    public function getGuildByPlayerId($playerId);
}
