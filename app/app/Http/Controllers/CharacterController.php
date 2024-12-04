<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\CharacterRepositoryInterface;

class CharacterController extends Controller
{
    protected $characterRepository;

    public function __construct(CharacterRepositoryInterface $characterRepository)
    {
        $this->characterRepository = $characterRepository;
    }

    /**
     * Criar um novo personagem.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'archetype' => 'required|in:Warrior,Mage,Archer,Cleric',
            'hp' => 'required|integer|min:1|max:100',
            'mp' => 'required|integer|min:1|max:100',
            'at' => 'required|integer|min:1|max:100',
            'df' => 'required|integer|min:1|max:100',
            'qa' => 'required|integer|min:1|max:5',
            'in' => 'required|integer|min:1|max:100',
            'xp' => 'required|integer|min:1'
        ]);

        $character = $this->characterRepository->createCharacter($validated);

        return response()->json([
            'message' => 'Character created successfully.',
            'character' => $character
        ], 201);
    }

    /**
     * Atualizar um personagem existente.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'archetype' => 'sometimes|required|in:Warrior,Mage,Archer,Cleric',
            'hp' => 'sometimes|required|integer|min:1|max:100',
            'mp' => 'sometimes|required|integer|min:1|max:100',
            'at' => 'sometimes|required|integer|min:1|max:100',
            'df' => 'sometimes|required|integer|min:1|max:100',
            'qa' => 'sometimes|required|integer|min:1|max:5',
            'in' => 'sometimes|required|integer|min:1|max:100',
            'xp' => 'sometimes|required|integer|min:1'
        ]);

        $character = $this->characterRepository->updateCharacter($id, $validated);

        if (!$character) {
            return response()->json(['message' => 'Character not found.'], 404);
        }

        return response()->json([
            'message' => 'Character updated successfully.',
            'character' => $character
        ], 200);
    }

    /**
     * Excluir um personagem existente.
     */
    public function destroy($id)
    {
        $success = $this->characterRepository->deleteCharacter($id);

        if (!$success) {
            return response()->json(['message' => 'Character not found.'], 404);
        }

        return response()->json(['message' => 'Character deleted successfully.'], 200);
    }

    /**
     * Buscar todos os personagens.
     */
    public function index()
    {
        $characters = $this->characterRepository->getAllCharacters();

        return response()->json([
            'message' => 'Characters retrieved successfully.',
            'characters' => $characters
        ], 200);
    }

    /**
     * Buscar um personagem específico por ID.
     */
    public function show($id)
    {
        $character = $this->characterRepository->getCharacterById($id);

        if (!$character) {
            return response()->json(['message' => 'Character not found.'], 404);
        }

        return response()->json([
            'message' => 'Character retrieved successfully.',
            'character' => $character
        ], 200);
    }

    /**
     * Busca os characters que não estão em guild_character
     */
    public function getAvailableCharacters()
    {
        $availableCharacters = $this->characterRepository->getAvailableCharacters();

        return response()->json($availableCharacters, 200);
    }
}
