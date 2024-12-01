<?php
namespace App\Services;

use App\Models\Player;

class GuildService
{

    public function createGuild()
    {

    }

    public function distributePlayers($guildSize): array
    {
        // Buscar jogadores confirmados e ordená-los por XP
        $confirmedPlayers = Player::where('confirmed', true)
                                  ->orderBy('xp', 'desc')
                                  ->get();

        $guilds = [];
        $currentGuild = [];
        $totalXpGuild = 0;

        foreach ($confirmedPlayers as $player) {
            // Adicionar jogador à guilda atual
            $currentGuild[] = $player;
            $totalXpGuild += $player->xp;

            // Verificar se atingiu o número máximo de jogadores por guilda
            if (count($currentGuild) >= $guildSize) {
                $guilds[] = [
                    'guild' => $currentGuild,
                    'total_xp' => $totalXpGuild
                ];
                $currentGuild = []; // Resetar a guilda atual
                $totalXpGuild = 0;  // Resetar XP total
            }
        }

        // Se restar algum jogador que não completou uma guilda, ele formará a última guilda
        if (count($currentGuild) > 0) {
            $guilds[] = [
                'guild' => $currentGuild,
                'total_xp' => $totalXpGuild
            ];
        }

        return $guilds;
    }
}
