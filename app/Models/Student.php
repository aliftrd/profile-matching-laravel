<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'nisn';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nisn',
        'major_id',
        'classroom_id',
        'name'
    ];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject_score')
            ->withPivot('score');
    }
}
