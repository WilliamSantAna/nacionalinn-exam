<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Campaign;
use App\Models\Guild;
use App\Models\Character;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
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
        $players = Player::where('campaign_id', $campaign_id)->get();

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
        $player = Player::find($id);

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

        $player = Player::create([
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
        // Busca o jogador pelo ID
        $player = Player::find($id);

        if (!$player) {
            return response()->json([
                'message' => 'Player not found.'
            ], 404);
        }

        // Validação dos dados da requisição
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'campaign_id' => 'sometimes|required|exists:campaigns,id',
            'confirmed' => 'sometimes|required|boolean'
        ]);

        // Atualiza o jogador
        $player->update($validated);

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
        // Busca o jogador pelo ID
        $player = Player::find($id);

        if (!$player) {
            return response()->json([
                'message' => 'Player not found.'
            ], 404);
        }

        // Deleta o jogador
        $player->delete();

        return response()->json([
            'message' => 'Player deleted successfully.'
        ], 200);
    }
}
