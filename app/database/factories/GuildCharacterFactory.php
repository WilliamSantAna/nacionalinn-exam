<?php

namespace Database\Factories;

use App\Models\GuildCharacter;
use App\Models\Guild;
use App\Models\Character;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuildCharacterFactory extends Factory
{
    protected $model = GuildCharacter::class;

    public function definition()
    {
        return [
            'guild_id' => Guild::factory(),
            'character_id' => Character::factory(),
        ];
    }
}
