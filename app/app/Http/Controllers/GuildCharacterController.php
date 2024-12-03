<?php

namespace App\Http\Controllers;

use App\Models\{GuildCharacter, Player, Guild};
use Illuminate\Http\Request;

class GuildCharacterController extends Controller
{
    /**
     * Lista todos os registros de GuildCharacter.
     */
    public function index()
    {
        $guildCharacters = GuildCharacter::all();
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
        $guildCharacter = GuildCharacter::find($id);

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
        // Valida os dados recebidos
        $validated = $request->validate([
            'guild_id' => 'required|exists:guilds,id',
            'character_id' => 'required|exists:characters,id',
        ]);

        // Cria o GuildCharacter
        $guildCharacter = GuildCharacter::create($validated);

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
        $guildCharacter = GuildCharacter::find($id);

        if (!$guildCharacter) {
            return response()->json([
                'message' => 'Guild Character not found.'
            ], 404);
        }

        // Valida os dados recebidos
        $validated = $request->validate([
            'guild_id' => 'sometimes|required|exists:guilds,id',
            'character_id' => 'sometimes|required|exists:characters,id',
        ]);

        // Atualiza os campos do GuildCharacter
        $guildCharacter->update($validated);

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
        $guildCharacter = GuildCharacter::find($id);

        if (!$guildCharacter) {
            return response()->json([
                'message' => 'Guild Character not found.'
            ], 404);
        }

        // Deleta o GuildCharacter
        $guildCharacter->delete();

        return response()->json([
            'message' => 'Guild Character deleted successfully.'
        ], 200);
    }

    public function getByGuild($guild_id)
    {
        $guildCharacters = GuildCharacter::where('guild_id', $guild_id)->get();
    
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

    public function getCharactersByPlayer($player_id)
    {
        $guild = Guild::where('player_id', $player_id)->first();
    
        if (!$guild) {
            return response()->json([
                'message' => 'Guild not found for the specified player.'
            ], 404);
        }
    
        $characters = $guild->characters;
    
        return response()->json([
            'message' => 'Characters retrieved successfully.',
            'characters' => $characters
        ], 200);
    }
    
    public function viewCharactersByPlayer($player_id)
    {
        $guild = Guild::where('player_id', $player_id)->first();
    
        if (!$guild) {
            return response()->json([
                'message' => 'Guild not found for the specified player.'
            ], 404);
        }
    
        $player = Player::find($player_id);
        $characters = $guild->characters;
    
        return view('guild-characters', [
            'player' => $player,
            'characters' => $characters
        ]);
    }

    public function addCharacter($guild_id, $character_id)
    {
        GuildCharacter::create([
            'guild_id' => $guild_id, 
            'character_id' => $character_id,
        ]);

        Guild::find($guild_id)->updateXp();

        return response()->json(['message' => 'Character added successfully.'], 200);
    }
    

    public function removeCharacter($guild_id, $character_id)
    {
        $guildCharacter = \App\Models\GuildCharacter::where('guild_id', $guild_id)
            ->where('character_id', $character_id)
            ->first();
    
        if ($guildCharacter) {
            $guildCharacter->delete();
            Guild::find($guild_id)->updateXp();

            return response()->json(['message' => 'Character removed successfully.'], 200);
        }
    
        return response()->json(['message' => 'Character not found in the guild.'], 404);
    }
    
        
}
