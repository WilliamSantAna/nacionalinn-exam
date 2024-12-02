<?php
namespace App\Services;

use App\Models\{Character, Guild, GuildCharacter, Player};
use Illuminate\Database\Eloquent\Collection;

class GuildService
{
    private Collection $characters;

    public function distributeCharacters()
    {
        $guildsDistribution = [];
        $this->characters = Character::orderBy('xp', 'desc')->get(); // Carregar os personagens ordenados por XP
        $players = Player::all(); // Carregar todos os players

        foreach ($players as $player) {
            $guild = $this->createGuildForPlayer($player); // Criar a guilda para o player
            if (!$guild) {
                return response()->json([
                    'message' => 'Não foi possível criar uma formação de guilda completa com os requisitos.',
                    'suggestion' => 'Tente uma formação com menos restrições ou mais personagens.'
                ], 400);
            }
            $guildsDistribution[] = $guild;
        }

        return $guildsDistribution;
    }

    /**
     * Método para criar a guilda para cada player
     */
    private function createGuildForPlayer(Player $player): mixed
    {
        $guildCharacters = [];

        // Filtrando os personagens por classe
        $clerics = $this->characters->where('archetype', 'Cleric');
        $warriors = $this->characters->where('archetype', 'Warrior');
        $mages = $this->characters->where('archetype', 'Mage');
        $archers = $this->characters->where('archetype', 'Archer');

        // Garantir que a guilda tenha pelo menos um Clérigo, Guerreiro e Mago ou Arqueiro
        // Se não for possível montar a guilda, retorna null
        if ($clerics->isEmpty() || $warriors->isEmpty() || ($mages->isEmpty() && $archers->isEmpty())) {
            return null;
        }

        // Seleciona o primeiro Clérigo, Guerreiro, e pelo menos um Mago ou Arqueiro
        $guildCharacters[] = $clerics->first();
        $guildCharacters[] = $warriors->first();
        if (!$mages->isEmpty()) {
            $guildCharacters[] = $mages->first();
        } else {
            $guildCharacters[] = $archers->first();
        }

        // Verifica se a guilda tem mais de 4 personagens. Se passar de 4 personagens, a guilda não é válida
        if (count($guildCharacters) > 4) {
            return null;
        }

        // Calcula o XP total da guilda
        $guildXp = $this->getGuildXP($guildCharacters);

        // Salva a guilda e os personagens associados
        $guild = $this->saveGuild($player, $guildCharacters, $guildXp);

        return ['guild' => $guild, 'characters' => $guildCharacters];
    }

    /**
     * Método para calcular o XP total de uma guilda
     */
    private function getGuildXP(array $guildCharacters): int
    {
        return array_sum(array_column($guildCharacters, 'xp'));
    }

    /**
     * Método para salvar a guilda e seus personagens associados
     */
    private function saveGuild(Player $player, array $guildCharacters, int $guildXp): Guild
    {
        $guild = Guild::create([
            'name' => $player->name . "'s Guild",
            'player_id' => $player->id,
            'xp' => $guildXp,
        ]);

        // Salvar os personagens na tabela guild_character
        foreach ($guildCharacters as $character) {
            GuildCharacter::create([
                'guild_id' => $guild->id,
                'character_id' => $character->id,
            ]);
        }

        // Remover os personagens já alocados para evitar repetição
        $this->characters = $this->characters->reject(function ($item) use ($guildCharacters) {
            return in_array($item->id, array_column($guildCharacters, 'id'));
        });

        return $guild;
    }
}
