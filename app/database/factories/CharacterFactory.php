<?php

namespace Database\Factories;

use App\Models\Character;
use Illuminate\Database\Eloquent\Factories\Factory;

class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function definition()
    {
        return [
            'archetype' => $this->faker->randomElement(['Warrior', 'Mage', 'Archer', 'Cleric']),
            'xp' => $this->faker->numberBetween(1, 100),
            'guild_id' => null,
        ];
    }
}
