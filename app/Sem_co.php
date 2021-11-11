<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sem_co extends Model
{

    protected $guarded=[];
    public function group(){
        return $this->belongsTo(Group::class,'group_id');
    }
    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }
    public function teacher(){
        return $this->belongsTo(Teacher::class,'teacher_id');
    }
    public function semester(){
        return $this->belongsTo(Semester::class,'semester_id');
    }
    public function lectures(){
        return $this->hasMany(Lecture::class, 'sem_co_id');
    }
}
