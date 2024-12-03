<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'archetype', 'name', 'xp', 'hp', 'mp', 'at', 'df', 'qa', 'in'
    ];

    public function guildCharacters()
    {
        return $this->hasMany(GuildCharacter::class);
    }

    public function guilds()
    {
        return $this->belongsToMany(Guild::class, 'guild_characters', 'character_id', 'guild_id');
    }    
}