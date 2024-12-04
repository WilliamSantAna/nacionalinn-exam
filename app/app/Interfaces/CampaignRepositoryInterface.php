<?php

namespace App\Interfaces;

interface CampaignRepositoryInterface
{
    public function getAllCampaigns();
    public function getCampaignById($id);
    public function createCampaign(array $data);
    public function updateCampaign($id, array $data);
    public function getPlayersByCampaign($campaignId);
    public function getAvailableCharacters($campaignId);
}
