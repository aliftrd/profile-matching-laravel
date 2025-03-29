<?php

namespace App\Models;

use App\Enum\CompetitionCriteriaSubjectType;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CompetitionCriteriaSubject extends Pivot
{
    public $timestamps = false;

    protected $casts = [
        'type' => CompetitionCriteriaSubjectType::class,
    ];

    public function criteria()
    {
        return $this->belongsTo(CompetitionCriteria::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
