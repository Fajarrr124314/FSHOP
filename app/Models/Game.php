<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'category',
        'title',
        'publisher',
        'image',
        'badge',
        'has_zone',
        'zone_placeholder',
    ];

    protected $casts = [
        'has_zone' => 'boolean',
    ];

    public function packages(): HasMany
    {
        return $this->hasMany(GamePackage::class, 'game_id', 'id');
    }
}
