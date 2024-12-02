<?php

namespace App\Http\Controllers;

use App\Services\GuildService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuildController extends Controller
{
    protected $guildService;

    public function __construct(GuildService $guildService)
    {
        $this->guildService = $guildService;
    }

    public function distribute(Request $request)
    {
        $guilds = $this->guildService->distributeCharacters();

        return response()->json(['message' => 'Guilds created successfully!', 'guilds' => $guilds]);
    }
    /**
     * Criar uma nova guilda.
     */
    public function store(Request $request)
    {
        // Validação dos dados da requisição
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'player_id' => 'required|exists:players,id',  // A guild deve pertencer a um player
        ]);

        // Criação da guilda
        $guild = Guild::create($validated);

        return response()->json([
            'message' => 'Guild created successfully.',
            'guild' => $guild
        ], 201);
    }

    /**
     * Atualizar uma guilda existente.
     */
    public function update(Request $request, $id)
    {
        // Busca a guilda pelo ID
        $guild = Guild::find($id);

        if (!$guild) {
            return response()->json(['message' => 'Guild not found.'], 404);
        }

        // Validação dos dados da requisição
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'player_id' => 'sometimes|required|exists:players,id',  // A guild deve pertencer a um player
        ]);

        // Atualiza a guilda com os dados validados
        $guild->update($validated);

        return response()->json([
            'message' => 'Guild updated successfully.',
            'guild' => $guild
        ], 200);
    }

    /**
     * Excluir uma guilda existente.
     */
    public function destroy($id)
    {
        $guild = Guild::find($id);

        if (!$guild) {
            return response()->json(['message' => 'Guild not found.'], 404);
        }

        $guild->delete();

        return response()->json(['message' => 'Guild deleted successfully.'], 200);
    }

    /**
     * Listar todas as guildas.
     */
    public function index()
    {
        $guilds = Guild::all();

        return response()->json([
            'message' => 'Guilds retrieved successfully.',
            'guilds' => $guilds
        ], 200);
    }

    /**
     * Buscar uma guilda específica por ID.
     */
    public function show($id)
    {
        $guild = Guild::find($id);

        if (!$guild) {
            return response()->json(['message' => 'Guild not found.'], 404);
        }

        return response()->json([
            'message' => 'Guild retrieved successfully.',
            'guild' => $guild
        ], 200);
    }
}