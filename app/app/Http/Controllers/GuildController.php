<?php

namespace App\Http\Controllers;

use App\Interfaces\GuildRepositoryInterface;
use App\Services\GuildService;
use Illuminate\Http\Request;
use App\Models\Campaign;

class GuildController extends Controller
{
    protected $guildRepository;
    protected $guildService;

    public function __construct(GuildRepositoryInterface $guildRepository, GuildService $guildService)
    {
        $this->guildRepository = $guildRepository;
        $this->guildService = $guildService;
    }

    public function distribute($campaignId)
    {
        $campaign = Campaign::find($campaignId);
        $guilds = $this->guildService->distributeCharacters($campaign);

        return response()->json(['message' => 'Guilds created successfully!', 'guilds' => $guilds]);
    }
    
    /**
     * Criar uma nova guilda.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'player_id' => 'required|exists:players,id',
        ]);

        // Verifica se o player já tem uma guild
        $existingGuild = $this->guildRepository->getGuildByPlayerId($validated['player_id']);
        if ($existingGuild) {
            return response()->json([
                'message' => 'This player already has a guild.'
            ], 400);
        }

        $guild = $this->guildRepository->createGuild($validated);

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
        $guild = $this->guildRepository->getGuildById($id);

        if (!$guild) {
            return response()->json(['message' => 'Guild not found.'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'player_id' => 'sometimes|required|exists:players,id',
        ]);

        $guild = $this->guildRepository->updateGuild($id, $validated);

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
        $success = $this->guildRepository->deleteGuild($id);

        if (!$success) {
            return response()->json(['message' => 'Guild not found.'], 404);
        }

        return response()->json(['message' => 'Guild deleted successfully.'], 200);
    }

    /**
     * Listar todas as guildas.
     */
    public function index()
    {
        $guilds = $this->guildRepository->getAllGuilds();

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
        $guild = $this->guildRepository->getGuildById($id);

        if (!$guild) {
            return response()->json(['message' => 'Guild not found.'], 404);
        }

        return response()->json([
            'message' => 'Guild retrieved successfully.',
            'guild' => $guild
        ], 200);
    }
}
