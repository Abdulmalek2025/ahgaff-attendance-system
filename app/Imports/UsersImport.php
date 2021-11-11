<?php

namespace App\Imports;

use App\User;
use App\Collage;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'userable_id'=>$row['student_id'],
            'userable_type'=>'App\Student',
            'email'=>$row['email'],
            'password'=>Hash::make(12345678),
            'type'=>'Student',
            'collage_id'=>Collage::where('name',$row['collage'])->first()->id

        ]);
    }
}
