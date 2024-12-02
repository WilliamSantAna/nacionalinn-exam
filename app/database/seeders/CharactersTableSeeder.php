<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Character;

class CharactersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * O XP dos personagens ja foi calculado:
         * Está usando a seguinte formula:
         * XP = (hp * 0.4) + (mp * 0.3) + (at * 0.2) + (df * 0.1) + (qa * 0.1) + (in * 0.2)
         * 
         * Onde:
         * hp: Pontos de vida (peso de 40%)
         * mp: Pontos de magia (peso de 30%)
         * at: Pontos de ataque (peso de 20%)
         * df: Pontos de defesa (peso de 10%)
         * qa: Quantidade de ataques (peso de 10%)
         * in: Pontos de iniciativa (peso de 20%)
         * 
         * A mecanica do jogo pode ser alterada apenas alterando os pesos da formula
         * Mas neste teste, não criaremos o jogo em si.
         * Faremos apenas a distribuição das guilds usando o XP
         * Os demais campos são apenas para demonstração, caso um jogo fosse criado
         * 
         * 
         * Os nomes dos characters foi gerado usando o site: https://plarium.com/pt/resource/generator/rpg-name-generator/
         */



        $characters = [
            // Warriors
            ['name' => 'Thorin', 'archetype' => 'Warrior', 'hp' => 84, 'mp' => 9, 'at' => 95, 'df' => 56, 'qa' => 4, 'in' => 60, 'xp' => 85],
            ['name' => 'Ragnar', 'archetype' => 'Warrior', 'hp' => 95, 'mp' => 15, 'at' => 88, 'df' => 38, 'qa' => 3, 'in' => 72, 'xp' => 92],
            ['name' => 'Galen', 'archetype' => 'Warrior', 'hp' => 68, 'mp' => 26, 'at' => 81, 'df' => 51, 'qa' => 5, 'in' => 53, 'xp' => 78],
            ['name' => 'Brakus', 'archetype' => 'Warrior', 'hp' => 100, 'mp' => 20, 'at' => 92, 'df' => 58, 'qa' => 2, 'in' => 46, 'xp' => 94],
            ['name' => 'Darius', 'archetype' => 'Warrior', 'hp' => 79, 'mp' => 11, 'at' => 78, 'df' => 45, 'qa' => 5, 'in' => 66, 'xp' => 80],

            // Mages
            ['name' => 'Althea', 'archetype' => 'Mage', 'hp' => 70, 'mp' => 95, 'at' => 14, 'df' => 37, 'qa' => 2, 'in' => 50, 'xp' => 52],
            ['name' => 'Eldric', 'archetype' => 'Mage', 'hp' => 60, 'mp' => 85, 'at' => 9, 'df' => 44, 'qa' => 1, 'in' => 72, 'xp' => 48],
            ['name' => 'Seraphina', 'archetype' => 'Mage', 'hp' => 77, 'mp' => 70, 'at' => 17, 'df' => 33, 'qa' => 3, 'in' => 62, 'xp' => 54],
            ['name' => 'Valtor', 'archetype' => 'Mage', 'hp' => 65, 'mp' => 92, 'at' => 12, 'df' => 52, 'qa' => 4, 'in' => 48, 'xp' => 46],
            ['name' => 'Lyra', 'archetype' => 'Mage', 'hp' => 82, 'mp' => 80, 'at' => 11, 'df' => 42, 'qa' => 5, 'in' => 61, 'xp' => 50],

            // Archers
            ['name' => 'Elira', 'archetype' => 'Archer', 'hp' => 75, 'mp' => 10, 'at' => 85, 'df' => 53, 'qa' => 4, 'in' => 62, 'xp' => 30],
            ['name' => 'Kaelen', 'archetype' => 'Archer', 'hp' => 68, 'mp' => 19, 'at' => 92, 'df' => 45, 'qa' => 3, 'in' => 67, 'xp' => 25],
            ['name' => 'Finnian', 'archetype' => 'Archer', 'hp' => 83, 'mp' => 11, 'at' => 91, 'df' => 57, 'qa' => 5, 'in' => 73, 'xp' => 35],
            ['name' => 'Aerin', 'archetype' => 'Archer', 'hp' => 77, 'mp' => 13, 'at' => 89, 'df' => 43, 'qa' => 2, 'in' => 70, 'xp' => 27],
            ['name' => 'Dorian', 'archetype' => 'Archer', 'hp' => 88, 'mp' => 17, 'at' => 84, 'df' => 60, 'qa' => 1, 'in' => 56, 'xp' => 23],

            // Clerics
            ['name' => 'Isolde', 'archetype' => 'Cleric', 'hp' => 74, 'mp' => 80, 'at' => 13, 'df' => 49, 'qa' => 3, 'in' => 64, 'xp' => 15],
            ['name' => 'Aric', 'archetype' => 'Cleric', 'hp' => 66, 'mp' => 88, 'at' => 8, 'df' => 46, 'qa' => 2, 'in' => 58, 'xp' => 10],
            ['name' => 'Lysandra', 'archetype' => 'Cleric', 'hp' => 80, 'mp' => 75, 'at' => 7, 'df' => 39, 'qa' => 4, 'in' => 54, 'xp' => 12],
            ['name' => 'Elysia', 'archetype' => 'Cleric', 'hp' => 60, 'mp' => 95, 'at' => 10, 'df' => 51, 'qa' => 5, 'in' => 66, 'xp' => 8],
            ['name' => 'Tiberius', 'archetype' => 'Cleric', 'hp' => 72, 'mp' => 90, 'at' => 6, 'df' => 53, 'qa' => 1, 'in' => 63, 'xp' => 5]
        ];

        foreach ($characters as $character_data) {
            Character::create($character_data);
        }
    }
}
