<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guild extends Model
{
    use HasFactory;

    protected $fillable = ['campaign_id', 'name'];

    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
