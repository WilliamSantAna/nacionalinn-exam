<?php

namespace App\Repositories;

use App\Models\Player;
use App\Models\Guild;
use App\Interfaces\PlayerRepositoryInterface;

class PlayerRepository implements PlayerRepositoryInterface
{
    public function getAllPlayersByCampaignId($campaignId)
    {
        return Player::where('campaign_id', $campaignId)->get();
    }

    public function getPlayerById($id)
    {
        return Player::find($id);
    }

    public function createPlayer(array $data)
    {
        return Player::create($data);
    }

    public function updatePlayer($id, array $data)
    {
        $player = Player::find($id);
        if ($player) {
            $player->update($data);
            return $player;
        }
        return null;
    }

    public function deletePlayer($id)
    {
        $player = Player::find($id);
        if ($player) {
            $player->delete();
            return true;
        }
        return false;
    }

    public function toggleConfirmation($id)
    {
        $player = Player::find($id);
        if ($player) {
            $player->confirmed = !$player->confirmed;
            $player->save();
            return $player;
        }
        return null;
    }
}
