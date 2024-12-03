<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guild extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'player_id', 'xp'];

    public function guildCharacters()
    {
        return $this->hasMany(GuildCharacter::class);
    }

    public function characters()
    {
        return $this->belongsToMany(Character::class, 'guild_characters', 'guild_id', 'character_id');
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function updateXp()
    {
        $totalXp = $this->characters()->sum('xp');
        $this->xp = $totalXp;
        $this->save();
    }    
}
