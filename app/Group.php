<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name','start_date','end_date'
    ];
    public function user()
    {
        return $this->belongsToMany(Student::class, 'student_groups', 'group_id', 'student_id');
    }
    public function sem_cos(){
        return $this->hasMany(Sem_co::class,'group_id');
    }
    public function attendances(){
        return $this->hasMany(Attendance::class, 'group_id');
    }
    public function collage(){
        return $this->belongsTo(Collage::class, 'collage_id');
    }
}
