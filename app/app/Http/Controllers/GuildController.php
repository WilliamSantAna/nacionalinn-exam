<?php

namespace App\Http\Controllers;

use App\Services\GuildService;
use Illuminate\Http\Request;

class GuildController extends Controller
{
    protected $guildService;

    public function __construct(GuildService $guildService)
    {
        $this->guildService = $guildService;
    }

    public function distribute(Request $request)
    {
        $guildSize = $request->input('guild_size', env('GUILD_SIZE')); // Padrão: 4 jogadores por guilda
        $guilds = $this->guildService->distributePlayers($guildSize);

        return response()->json([
            'guilds' => $guilds
        ]);
    }
}
