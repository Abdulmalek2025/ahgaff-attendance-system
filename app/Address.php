<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded=[];
    protected $fillable = [
        'country', 'city', 'street','addressable_id','addressable_type'
    ];
    public function addressable(){
        return $this->morphTo();
    }
}
