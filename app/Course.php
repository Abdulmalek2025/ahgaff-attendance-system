<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function sem_cos(){
        return $this->hasMany(Sem_co::class,'course_id');
    }
    public function collage(){
        return $this->belongsTo(Collage::class, 'collage_id');
    }
}
