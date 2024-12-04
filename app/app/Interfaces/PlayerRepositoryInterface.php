<?php

namespace App\Interfaces;

interface PlayerRepositoryInterface
{
    public function getAllPlayersByCampaignId($campaignId);
    public function getPlayerById($id);
    public function createPlayer(array $data);
    public function updatePlayer($id, array $data);
    public function deletePlayer($id);
    public function toggleConfirmation($id);
}
