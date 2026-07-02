<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Service extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'category',
        'title',
        'image',
        'short_desc',
        'price',
        'tags',
        'features',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'features' => 'array',
        ];
    }
}
