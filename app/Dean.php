<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dean extends Model
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
}
