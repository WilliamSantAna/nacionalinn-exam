<?php
namespace App\Services;

use App\Models\{Character, Guild, GuildCharacter, Player, Campaign};
use Illuminate\Database\Eloquent\Collection;
use \Random\Randomizer as Randomizer;

class GuildService
{
    private Collection $characters;

    public function distributeCharacters(Campaign $campaign)
    {
        $guildsDistribution = [];
        $this->characters = Character::orderBy('xp', 'desc')->get(); // Carregar os personagens ordenados por XP decrescente
        
        $this->clearAllGuilds($campaign);
        $players = $this->getConfirmedPlayers($campaign); // Carregar os players confirmados da campaign

        foreach ($players as $player) {
            $guild = $this->createGuildForPlayer($player); // Criar a guilda para o player
            $guildsDistribution[] = $guild;
        }

        return $guildsDistribution;
        
    }

    private function clearAllGuilds(Campaign $campaign) 
    {
        $players = $campaign->players;
        foreach ($players as $player) {
            if ($player->guild != null) {
                $player->guild->delete();
            }

            Guild::create([
                'player_id' => $player->id,
                'name' => $player->name . "'s Guild", 
                'xp' => 0
            ]);
        }
    }

    private function getConfirmedPlayers(Campaign $campaign)
    {
        return $campaign->players()->where('confirmed', true)->get();
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

        // Seleciona o primeiro Guerreiro, Clérigo e pelo menos um Mago ou Arqueiro
        $guildCharacters[] = $warriors->first();
        $guildCharacters[] = $clerics->first();

        $next = ['mages', 'archers'];
        shuffle($next);
        if ($next[0] == 'mages') {
            $guildCharacters[] = $mages->shift();
            if (!$archers->isEmpty()) {
                $guildCharacters[] = $archers->shift();
            }
        }
        else {
            $guildCharacters[] = $archers->shift();
            if (!$mages->isEmpty()) {
                $guildCharacters[] = $mages->shift();
            }
        }

        // Verifica se a guilda tem mais de 4 personagens. Se passar de 4 personagens, a guilda não é válida
        if (count($guildCharacters) > 4) {
            return null;
        }

        // Salva a guilda e os personagens associados
        $guild = $this->saveGuild($player, $guildCharacters);

        return ['guild' => $guild, 'player' => $player, 'characters' => $guildCharacters];
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
    private function saveGuild(Player $player, array $guildCharacters): Guild
    {

        $guild = $player->guild;
        $guild->xp = $this->getGuildXP($guildCharacters);
        $guild->save();
        
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
