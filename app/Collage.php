<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Collage extends Model

{

    protected $guarded=[];
    protected $fillable = [
        'name','location','telephone'
    ];
    public function users(){
        return $this->hasMany(User::class,'collage_id');
    }
    public function groups(){
        return $this->hasMany(Group::class,'collage_id');
    }
    public function courses(){
        return $this->hasMany(Course::class,'collage_id');
    }
    public function majors(){
        return $this->hasMany(Major::class,'collage_id');

    }

}
