<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'id',
        'name',
        'province',
    ];

    protected $keyType = 'string';
    public $incrementing = false;
}
