<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuildCharacter extends Model
{
    use HasFactory;

    protected $fillable = [
        'guild_id', 
        'character_id',
        'hpa', // pontos de vida atual
        'mpa', // pontos de magia atual
    ];

    public function guild()
    {
        return $this->belongsTo(Guild::class);
    }

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
