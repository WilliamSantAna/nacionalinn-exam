<?php

namespace App\Http\Controllers;

use App\Models\{Player, Campaign, Guild, Character};
use App\Interfaces\PlayerRepositoryInterface;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    protected $playerRepository;

    public function __construct(PlayerRepositoryInterface $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * Retorna a view de criação de jogador.
     */
    public function new($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);
        if (!$campaign) {
            return response()->json([
                'message' => 'Campaign not found.'
            ], 404);
        }

        $players = $campaign->players;
        $characters = Character::orderBy('name', 'asc')->get();
    
        return view('new-player', [
            'campaign' => $campaign,
            'players' => $players,
            'characters' => $characters,
        ]);
    }

    /**
     * Lista todos os Players de uma Campaign.
     */
    public function index(Request $request)
    {
        $campaign_id = $request->query('campaign_id');
        $players = $this->playerRepository->getAllPlayersByCampaignId($campaign_id);

        return response()->json([
            'message' => 'Players retrieved successfully.',
            'players' => $players
        ], 200);
    }

    /**
     * Exibe um jogador específico.
     */
    public function show($id)
    {
        $player = $this->playerRepository->getPlayerById($id);

        if (!$player) {
            return response()->json([
                'message' => 'Player not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Player retrieved successfully.',
            'player' => $player
        ], 200);
    }

    /**
     * Cria um novo jogador.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'campaign_id' => 'required|exists:campaigns,id'
        ]);

        $player = $this->playerRepository->createPlayer([
            'name' => $validated['name'],
            'campaign_id' => $validated['campaign_id'],
            'confirmed' => false,
        ]);

        $guild = Guild::create([
            'name' => $player->name . "'s Guild",
            'player_id' => $player->id, 
            'xp' => 0
        ]);

        return response()->json([
            'message' => 'Player created successfully.',
            'player' => $player,
            'guild' => $guild,
        ], 201);
    }

    /**
     * Atualiza um jogador existente.
     */
    public function update(Request $request, $id)
    {
        $player = $this->playerRepository->getPlayerById($id);

        if (!$player) {
            return response()->json([
                'message' => 'Player not found.'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'campaign_id' => 'sometimes|required|exists:campaigns,id',
            'confirmed' => 'sometimes|required|boolean'
        ]);

        $player = $this->playerRepository->updatePlayer($id, $validated);

        return response()->json([
            'message' => 'Player updated successfully.',
            'player' => $player
        ], 200);
    }

    /**
     * Deleta um jogador.
     */
    public function destroy($id)
    {
        $success = $this->playerRepository->deletePlayer($id);

        if (!$success) {
            return response()->json([
                'message' => 'Player not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Player deleted successfully.'
        ], 200);
    }

    public function toggleConfirmation($id)
    {
        $player = $this->playerRepository->toggleConfirmation($id);

        if (!$player) {
            return response()->json(['message' => 'Player not found.'], 404);
        }

        return response()->json(['message' => 'Player confirmation updated.', 'confirmed' => $player->confirmed], 200);
    }    
}
