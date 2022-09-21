<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $fillable = [
        'title',
        'address',
        'capacity',
        'is_in_abroad',
    ];
}
