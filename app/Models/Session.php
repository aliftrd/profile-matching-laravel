<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public $keyType = 'string';
    public $incrementing = false;

    public function scopeForCurrentUser($query)
    {
        return $query->where('user_id', auth()->id());
    }
}
