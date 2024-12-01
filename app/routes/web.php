<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuildController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/distribute-guilds', [GuildController::class, 'distribute']);