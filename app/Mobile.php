<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mobile extends Model
{
    protected $guarded=[];
    protected $fillable = [
        'mobile','mobileable_id','mobileable_type'
    ];
    public function mobileable(){
        return $this->morphTo();
    }
}
