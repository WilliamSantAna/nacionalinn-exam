<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'campaign_id', 'confirmed'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function guild()
    {
        return $this->hasOne(Guild::class);
    }
}
