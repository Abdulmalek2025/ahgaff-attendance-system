<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
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
    public function sem_cos(){
        return $this->hasMany(Sem_co::class,'teacher_id');
    }
}
