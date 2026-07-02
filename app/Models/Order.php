<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'customer_name',
        'customer_phone',
        'type',
        'items',
        'total_price',
        'payment_status',
        'payment_method',
        'doku_invoice_id',
    ];

    protected function casts(): array
    {
        return [
            'items' => 'array',
        ];
    }
}
