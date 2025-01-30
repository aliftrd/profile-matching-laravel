<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $fillable = ['name', 'major_id'];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function criterias()
    {
        return $this->hasMany(CompetitionCriteria::class);
    }
}
