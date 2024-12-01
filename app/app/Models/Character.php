<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'archetype', 'guild_id', 'name', 'xp', 'hp', 'mp', 'at', 'df', 'qa', 'in'
    ];

    public function guild()
    {
        return $this->belongsTo(Guild::class);
    }
}