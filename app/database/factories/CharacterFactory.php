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