<?php

namespace App\Repositories;

use App\Models\Character;
use App\Interfaces\CharacterRepositoryInterface;

class CharacterRepository implements CharacterRepositoryInterface
{
    protected $character;

    public function __construct(Character $character)
    {
        $this->character = $character;
    }

    public function getAllCharacters()
    {
        return $this->character::all();
    }

    public function getCharacterById($id)
    {
        return $this->character::find($id);
    }

    public function createCharacter(array $data)
    {
        return $this->character::create($data);
    }

    public function updateCharacter($id, array $data)
    {
        $character = $this->character::find($id);
        if ($character) {
            $character->update($data);
            return $character;
        }
        return null;
    }

    public function deleteCharacter($id)
    {
        $character = $this->character::find($id);
        if ($character) {
            $character->delete();
            return true;
        }
        return false;
    }

    public function getAvailableCharacters()
    {
        return $this->character::whereDoesntHave('guildCharacters')->get();
    }
}
