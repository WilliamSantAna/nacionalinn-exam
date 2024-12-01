<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = ['guild_id', 'archetype', 'xp'];

    public function guild()
    {
        return $this->belongsTo(Guild::class);
    }
}
