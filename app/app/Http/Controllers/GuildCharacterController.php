<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\{
    GuildCharacterRepositoryInterface,
    GuildRepositoryInterface,
    PlayerRepositoryInterface
};

class GuildCharacterController extends Controller
{
    protected $guildCharacterRepository;
    protected $guildRepository;
    protected $playerRepository;

    public function __construct(
        GuildCharacterRepositoryInterface $guildCharacterRepository,
        GuildRepositoryInterface $guildRepository,
        PlayerRepositoryInterface $playerRepository,
    )
    {
        $this->guildCharacterRepository = $guildCharacterRepository;
        $this->guildRepository = $guildRepository;
        $this->playerRepository = $playerRepository;
    }

    /**
     * Lista todos os registros de GuildCharacter.
     */
    public function index()
    {
        $guildCharacters = $this->guildCharacterRepository->getAllGuildCharacters();
        return response()->json([
            'message' => 'Guild Characters retrieved successfully.',
            'guild_characters' => $guildCharacters
        ], 200);
    }

    /**
     * Retorna um GuildCharacter específico pelo ID.
     */
    public function show($id)
    {
        $guildCharacter = $this->guildCharacterRepository->getGuildCharacterById($id);

        if (!$guildCharacter) {
            return response()->json([
                'message' => 'Guild Character not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Guild Character retrieved successfully.',
            'guild_character' => $guildCharacter
        ], 200);
    }

    /**
     * Cria um novo GuildCharacter.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'guild_id' => 'required|exists:guilds,id',
            'character_id' => 'required|exists:characters,id',
        ]);

        $guildCharacter = $this->guildCharacterRepository->createGuildCharacter($validated);

        return response()->json([
            'message' => 'Guild Character created successfully.',
            'guild_character' => $guildCharacter
        ], 201);
    }

    /**
     * Atualiza um GuildCharacter existente.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'guild_id' => 'sometimes|required|exists:guilds,id',
            'character_id' => 'sometimes|required|exists:characters,id',
        ]);

        $guildCharacter = $this->guildCharacterRepository->updateGuildCharacter($id, $validated);

        if (!$guildCharacter) {
            return response()->json([
                'message' => 'Guild Character not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Guild Character updated successfully.',
            'guild_character' => $guildCharacter
        ], 200);
    }

    /**
     * Deleta um GuildCharacter pelo ID.
     */
    public function destroy($id)
    {
        $success = $this->guildCharacterRepository->deleteGuildCharacter($id);

        if (!$success) {
            return response()->json([
                'message' => 'Guild Character not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Guild Character deleted successfully.'
        ], 200);
    }

    /**
     * Busca os characters de uma guild.
     */
    public function getByGuild($guild_id)
    {
        $guildCharacters = $this->guildCharacterRepository->getGuildCharactersByGuild($guild_id);

        if ($guildCharacters->isEmpty()) {
            return response()->json([
                'message' => 'No Guild Characters found for the specified Guild.'
            ], 404);
        }

        return response()->json([
            'message' => 'Guild Characters retrieved successfully.',
            'guild_characters' => $guildCharacters
        ], 200);
    }

    /**
     * Busca os characters de um player.
     */
    public function getCharactersByPlayer($player_id)
    {
        $characters = $this->guildCharacterRepository->getCharactersByPlayer($player_id);

        if (!$characters) {
            return response()->json([
                'message' => 'No characters found for the specified player.'
            ], 404);
        }

        return response()->json([
            'message' => 'Characters retrieved successfully.',
            'characters' => $characters
        ], 200);
    }

    /**
     * Adiciona um personagem a uma guild.
     */
    public function addCharacter($guild_id, $character_id)
    {
        $this->guildCharacterRepository->addCharacterToGuild($guild_id, $character_id);
        return response()->json(['message' => 'Character added successfully.'], 200);
    }

    /**
     * Remove um personagem de uma guild.
     */
    public function removeCharacter($guild_id, $character_id)
    {
        $this->guildCharacterRepository->removeCharacterFromGuild($guild_id, $character_id);
        return response()->json(['message' => 'Character removed successfully.'], 200);
    }

    /**
     * Buscar os personagens por player
     */
    public function viewCharactersByPlayer($player_id)
    {
        $guild = $this->guildRepository->getGuildByPlayerId($player_id);

        if (!$guild) {
            return response()->json([
                'message' => 'Guild not found for the specified player.'
            ], 404);
        }

        $player = $this->playerRepository->getPlayerById($player_id);
        $characters = $this->guildCharacterRepository->getCharactersByGuild($guild->id);

        return view('guild-characters', [
            'player' => $player,
            'characters' => $characters
        ]);
    }
}
