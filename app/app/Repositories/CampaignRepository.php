<?php

namespace App\Repositories;

use App\Models\{Campaign, Guild, Character};
use App\Interfaces\CampaignRepositoryInterface;
use Illuminate\Support\Carbon;

class CampaignRepository implements CampaignRepositoryInterface
{
    public function getAllCampaigns()
    {
        return Campaign::all();
    }

    public function getCampaignById($id)
    {
        return Campaign::find($id);
    }

    public function createCampaign(array $data)
    {
        return Campaign::create([
            'name' => $data['name'],
            'start_date' => Carbon::now(),
        ]);
    }

    public function updateCampaign($id, array $data)
    {
        $campaign = Campaign::find($id);
        if ($campaign) {
            $campaign->update($data);
            return $campaign;
        }
        return null;
    }

    public function getPlayersByCampaign($campaignId)
    {
        $campaign = Campaign::find($campaignId);
        return $campaign ? $campaign->players : null;
    }

    public function getAvailableCharacters($campaignId)
    {
        $campaign = Campaign::find($campaignId);
        if (!$campaign) {
            return null;
        }

        // Obtem os IDs dos players da campanha
        $playerIds = $campaign->players()->pluck('id')->toArray();

        // Obtem os IDs das guilds associadas aos players
        $guildIds = Guild::whereIn('player_id', $playerIds)->pluck('id')->toArray();

        // Retorna os personagens não associados a essas guilds
        return Character::when(empty($guildIds), function ($query) {
            return $query;
        }, function ($query) use ($guildIds) {
            return $query->whereDoesntHave('guildCharacters', function ($query) use ($guildIds) {
                $query->whereIn('guild_id', $guildIds);
            });
        })->get();
    }
}
