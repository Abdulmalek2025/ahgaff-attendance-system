<?php

namespace App\Imports;

use App\Mobile;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class MobilesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        return new Mobile([
            'mobileable_id'=>$row['student_id'],
            'mobileable_type'=>'App\Student',
            'mobile'=>$row['mobile1']
        ]);
        
    }
}
