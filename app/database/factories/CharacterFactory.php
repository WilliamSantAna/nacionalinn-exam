<?php

namespace Database\Factories;

use App\Models\Character;
use App\Models\Guild;
use Illuminate\Database\Eloquent\Factories\Factory;

class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function definition()
    {
        return [
            'archetype' => $this->faker->randomElement(['Warrior', 'Mage', 'Archer', 'Cleric']),
            'guild_id' => Guild::factory(),
            'xp' => $this->faker->numberBetween(1, 100),
        ];
    }
}


Agora sabendo desse cenário que temos, vamos criar nosso GuildService.
Precisamos de um metodo onde ele distribua os characters nas guilds.
Depois outro metodo que irá distribuir as guilds para os players, levando em conta que fique de forma equilibrada, ou seja, os players terão guilds cuja xp fique equivalente.
Uma campaign pode ter varios players, lembre-se disso.


Se precisar do codigo como está no momento, basta pedir.