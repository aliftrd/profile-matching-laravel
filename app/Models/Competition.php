<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $fillable = ['name'];

    public function majors()
    {
        return $this->belongsToMany(Major::class);
    }

    public function criterias()
    {
        return $this->hasMany(CompetitionCriteria::class);
    }
}
