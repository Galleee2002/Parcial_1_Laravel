<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'short_description',
        'full_description',
        'price',
        'delivery_days',
        'is_active',
    ];

    public function price(): Attribute
    {
        return Attribute::make(
            function ($value) {
                return $value / 100;
            },
            function ($value) {
                return $value * 100;
            },
        );
    }
}