<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    GuildController,
    CampaignController,
    PlayerController,
    CharacterController,
    GuildCharacterController
};

Route::get('/', function () {
    return view('welcome');
});


Route::get('/distribute-guilds', [GuildController::class, 'distribute']);

Route::post('/campaigns', [CampaignController::class, 'store']);
Route::get('/campaigns', [CampaignController::class, 'index']);
Route::get('/campaigns/{id}', [CampaignController::class, 'show']);
Route::put('/campaigns/{id}', [CampaignController::class, 'update']);

Route::post('/characters', [CharacterController::class, 'store']);
Route::put('/characters/{id}', [CharacterController::class, 'update']);
Route::delete('/characters/{id}', [CharacterController::class, 'destroy']);
Route::get('/characters', [CharacterController::class, 'index']);
Route::get('/characters/{id}', [CharacterController::class, 'show']);

Route::post('/players', [PlayerController::class, 'store']);
Route::put('/players/{id}', [PlayerController::class, 'update']);
Route::delete('/players/{id}', [PlayerController::class, 'destroy']);
Route::get('/players', [PlayerController::class, 'index']);
Route::get('/players/{id}', [PlayerController::class, 'show']);

Route::post('/guild-characters', [GuildCharacterController::class, 'store']);
Route::put('/guild-characters/{id}', [GuildCharacterController::class, 'update']);
Route::delete('/guild-characters/{id}', [GuildCharacterController::class, 'destroy']);
Route::get('/guild-characters', [GuildCharacterController::class, 'index']);
Route::get('/guild-characters/{id}', [GuildCharacterController::class, 'show']);

Route::post('/guilds', [GuildController::class, 'store']);
Route::put('/guilds/{id}', [GuildController::class, 'update']);
Route::delete('/guilds/{id}', [GuildController::class, 'destroy']);
Route::get('/guilds', [GuildController::class, 'index']);
Route::get('/guilds/{id}', [GuildController::class, 'show']);
