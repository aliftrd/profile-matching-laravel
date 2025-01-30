<?php

namespace App\Models;

use App\Enum\CompetitionCriteriaType;
use Illuminate\Database\Eloquent\Model;

class CompetitionCriteria extends Model
{
    protected $fillable = [
        'competition_id',
        'name',
        'weight',
        'type',
    ];

    protected $casts = [
        'type' => CompetitionCriteriaType::class,
    ];

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }
}
