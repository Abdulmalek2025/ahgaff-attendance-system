<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $guarded=[];
    public function sem_co(){
        return $this->belongsTo(Sem_co::class, 'sem_co_id');
    }
    public function attendances(){
        return $this->hasMany(Attendance::class, 'lec_id');
    }
}
