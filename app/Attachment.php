<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $guarded=[];
    protected $fillable = [
        'path',
    ];
    public function attachmentable(){
        return $this->morphTo();
    }
}
