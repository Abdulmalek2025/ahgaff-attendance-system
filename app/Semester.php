<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $guarded=[];
    protected $fillable = [
        'name'
    ];
    public function sem_cos(){
        return $this->hasMany(Sem_co::class,'semester_id');
    }
    public function students(){
        return $this->hasMany(Student::class,'semester_id');
    }
}
