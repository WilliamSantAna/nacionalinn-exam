<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = ['campaign_id', 'name', 'confirmed'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
