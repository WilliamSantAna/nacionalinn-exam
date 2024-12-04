<?php

namespace App\Interfaces;

interface CharacterRepositoryInterface
{
    public function getAllCharacters();
    public function getCharacterById($id);
    public function createCharacter(array $data);
    public function updateCharacter($id, array $data);
    public function deleteCharacter($id);
    public function getAvailableCharacters();
}
