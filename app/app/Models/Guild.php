<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guild extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'player_id'];

    public function guildCharacters()
    {
        return $this->hasMany(GuildCharacter::class);
    }

    public function characters()
    {
        return $this->hasManyThrough(Character::class, GuildCharacter::class);
    }
}
