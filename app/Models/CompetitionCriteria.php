<?php

namespace App\Models;

use App\Enum\CompetitionCriteriaSubjectType;
use Illuminate\Database\Eloquent\Model;

class CompetitionCriteria extends Model
{
    protected $fillable = [
        'competition_id',
        'name',
        'weight',
    ];

    protected $casts = [
        'subjects.pivot.type' => CompetitionCriteriaSubjectType::class,
    ];

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class)
            ->using(CompetitionCriteriaSubject::class)
            ->withPivot('type', 'target_score');
    }

    public function criteriaSubjects()
    {
        return $this->hasMany(CompetitionCriteriaSubject::class, 'competition_criteria_id');
    }
}
