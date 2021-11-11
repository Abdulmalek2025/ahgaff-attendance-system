<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $guarded=[];
    protected $fillable = [
        'name','collage_id'
    ];
    public function students(){
        return $this->hasMany(Student::class,'major_id');
    }
    public function collage(){
        return $this->belongsTo(Collage::class, 'collage_id');
    }
}
