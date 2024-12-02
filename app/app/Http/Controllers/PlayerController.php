<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;

class PlayerController extends Controller
{
    /**
     * Criar um novo player.
     */
    public function store(Request $request)
    {
        // Valida os dados da requisição
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:players,email',
            'age' => 'required|integer|min:1'
        ]);

        // Criação do player
        $player = Player::create($validated);

        return response()->json([
            'message' => 'Player created successfully.',
            'player' => $player
        ], 201);
    }

    /**
     * Atualizar um player existente.
     */
    public function update(Request $request, $id)
    {
        // Busca o player pelo ID
        $player = Player::find($id);

        if (!$player) {
            return response()->json(['message' => 'Player not found.'], 404);
        }

        // Valida os dados da requisição
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:players,email,' . $id,
            'age' => 'sometimes|required|integer|min:1'
        ]);

        // Atualiza o player com os dados validados
        $player->update($validated);

        return response()->json([
            'message' => 'Player updated successfully.',
            'player' => $player
        ], 200);
    }

    /**
     * Excluir um player existente.
     */
    public function destroy($id)
    {
        $player = Player::find($id);

        if (!$player) {
            return response()->json(['message' => 'Player not found.'], 404);
        }

        $player->delete();

        return response()->json(['message' => 'Player deleted successfully.'], 200);
    }

    /**
     * Buscar todos os players.
     */
    public function index()
    {
        $players = Player::all();

        return response()->json([
            'message' => 'Players retrieved successfully.',
            'players' => $players
        ], 200);
    }

    /**
     * Buscar um player específico por ID.
     */
    public function show($id)
    {
        $player = Player::find($id);

        if (!$player) {
            return response()->json(['message' => 'Player not found.'], 404);
        }

        return response()->json([
            'message' => 'Player retrieved successfully.',
            'player' => $player
        ], 200);
    }
}
