<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded=[];
    public function user(){
        return $this->morphOne(User::class,'userable');
    }
    public function addresses(){
        return $this->morphMany(Address::class,'addressable');
    }
    public function mobiles(){
        return $this->morphMany(Mobile::class,'mobileable');
    }
    public function group()
    {
        return $this->belongsToMany(Group::class, 'student_groups', 'student_id', 'group_id');
    }
    public function attendances(){
        return $this->hasMany(Attendance::class, 'student_id');
    }
    public function excuses(){
        return $this->hasMany(Excuse::class,'student_id');
    }
    public function ill_excuses(){
        return $this->hasMany(Ill_Excuse::class,'student_id');
    }
    public function semester(){
        return $this->belongsTo(Semester::class,'semester_id');
    }
    public function major(){
        return $this->belongsTo(Major::class,'major_id');
    }
}
