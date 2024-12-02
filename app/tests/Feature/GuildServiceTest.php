<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\{Character, Guild, Player};
use App\Services\GuildService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;

class GuildServiceTest extends TestCase
{
    use RefreshDatabase;

    private $guildService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->guildService = new GuildService();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_creates_a_guild_with_required_characters()
    {
        // Criando personagens para a guilda
        $cleric = Character::factory()->create(['archetype' => 'Cleric']);
        $warrior = Character::factory()->create(['archetype' => 'Warrior']);
        $mage = Character::factory()->create(['archetype' => 'Mage']);
        $archer = Character::factory()->create(['archetype' => 'Archer']);
        
        // Criando o jogador
        $player = Player::factory()->create();

        // Simulando a distribuição de personagens
        $this->guildService->distributeCharacters();

        // Garantir que a guilda foi criada e associada ao jogador
        $guild = Guild::first();
        $this->assertNotNull($guild);
        $this->assertEquals($guild->player_id, $player->id);
        $this->assertEquals($guild->characters->count(), 4); // Verifica se a guilda tem 4 personagens
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_does_not_create_a_guild_if_there_are_not_enough_characters()
    {
        // Criando apenas um Clérigo e um Guerreiro (faltam Mage ou Archer)
        $cleric = Character::factory()->create(['archetype' => 'Cleric']);
        $warrior = Character::factory()->create(['archetype' => 'Warrior']);

        // Criando o jogador
        $player = Player::factory()->create();

        // Tentando criar a guilda
        $guild = $this->guildService->distributeCharacters();

        // Garantir que a guilda não foi criada
        $this->assertEmpty($guild); 
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_creates_a_guild_with_balanced_xp()
    {
        // Criando personagens com diferentes XP
        $cleric = Character::factory()->create(['archetype' => 'Cleric', 'xp' => 10]);
        $warrior = Character::factory()->create(['archetype' => 'Warrior', 'xp' => 100]);
        $mage = Character::factory()->create(['archetype' => 'Mage', 'xp' => 50]);
        $archer = Character::factory()->create(['archetype' => 'Archer', 'xp' => 30]);

        // Criando o jogador
        $player = Player::factory()->create();

        // Simulando a distribuição de personagens
        $this->guildService->distributeCharacters();

        // Verificar se o XP total da guilda foi calculado corretamente
        $guild = Guild::first();
        $this->assertEquals($guild->xp, 190); // 10 + 100 + 50 + 30
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_removes_characters_from_available_list_after_adding_to_guild()
    {
        // Criando personagens
        $cleric = Character::factory()->create(['archetype' => 'Cleric']);
        $warrior = Character::factory()->create(['archetype' => 'Warrior']);
        $mage = Character::factory()->create(['archetype' => 'Mage']);
        $archer = Character::factory()->create(['archetype' => 'Archer']);
        
        // Criando o jogador
        $player = Player::factory()->create();

        // Simulando a distribuição de personagens
        $this->guildService->distributeCharacters();

        // Verifica se os personagens alocados foram removidos da lista
        $remainingCharacters = $this->guildService->characters;
        $this->assertEquals($remainingCharacters->count(), 0); // Nenhum personagem deve sobrar
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_does_not_create_more_than_4_characters_in_a_guild()
    {
        // Criando mais de 4 personagens
        $cleric = Character::factory()->create(['archetype' => 'Cleric']);
        $warrior = Character::factory()->create(['archetype' => 'Warrior']);
        $mage = Character::factory()->create(['archetype' => 'Mage']);
        $archer = Character::factory()->create(['archetype' => 'Archer']);
        $extraCharacter = Character::factory()->create(['archetype' => 'Warrior']);

        // Criando o jogador
        $player = Player::factory()->create();

        // Simulando a distribuição de personagens
        $guild = $this->guildService->distributeCharacters();

        // Verifica se a guilda não foi criada com mais de 4 personagens
        $this->assertNotNull($guild);
        $this->assertCount(4, $guild['characters']); // Apenas 4 personagens devem ser alocados
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_creates_multiple_guilds_for_multiple_players()
    {
        // Criando personagens e players
        $cleric = Character::factory()->create(['archetype' => 'Cleric']);
        $warrior = Character::factory()->create(['archetype' => 'Warrior']);
        $mage = Character::factory()->create(['archetype' => 'Mage']);
        $archer = Character::factory()->create(['archetype' => 'Archer']);
        $player1 = Player::factory()->create();
        $player2 = Player::factory()->create();

        // Simulando a distribuição de personagens
        $this->guildService->distributeCharacters();

        // Verifica se duas guildas foram criadas, uma para cada jogador
        $guilds = Guild::all();
        $this->assertCount(2, $guilds);
    }
}
