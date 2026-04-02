<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinRequest extends Model
{
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'reason',
        'status',
        'rejection_reason',
    ];
}
