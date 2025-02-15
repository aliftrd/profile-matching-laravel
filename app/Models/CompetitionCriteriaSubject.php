<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CompetitionCriteriaSubject extends Pivot
{
    public $timestamps = false;

    public function criteria()
    {
        return $this->belongsTo(CompetitionCriteria::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
