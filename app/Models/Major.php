<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $fillable = ['name'];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function competitions()
    {
        return $this->belongsToMany(Competition::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
