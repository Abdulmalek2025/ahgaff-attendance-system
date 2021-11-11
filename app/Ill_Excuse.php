<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ill_Excuse extends Model
{
    public function attendances(){
        return $this->morphMany(Attendance::class,'attendanceable');
    }
    public function attachments(){
        return $this->morphMany(Attachment::class,'attachmentable');
    }
    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }
}
