<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name'];

    public function majors()
    {
        return $this->belongsToMany(Major::class);
    }

    public function competitionCriteria()
    {
        return $this->belongsToMany(CompetitionCriteria::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_subject_score')
            ->withPivot('score');
    }
}
