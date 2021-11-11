<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded=[];
    public function lecture(){
        return $this->belongsTo(Lecture::class, 'lec_id');
    }
    public function group(){
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function attendanceable(){
        return $this->morphTo();
    }
}
