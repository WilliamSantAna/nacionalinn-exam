<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\{
    CampaignRepositoryInterface,
    CharacterRepositoryInterface,
    GuildCharacterRepositoryInterface,
    GuildRepositoryInterface,
    PlayerRepositoryInterface
};
use App\Repositories\{
    CampaignRepository,
    CharacterRepository,
    GuildCharacterRepository,
    GuildRepository,
    PlayerRepository
};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CampaignRepositoryInterface::class, CampaignRepository::class);
        $this->app->bind(CharacterRepositoryInterface::class, CharacterRepository::class);
        $this->app->bind(GuildCharacterRepositoryInterface::class, GuildCharacterRepository::class);
        $this->app->bind(GuildRepositoryInterface::class, GuildRepository::class);
        $this->app->bind(PlayerRepositoryInterface::class, PlayerRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
