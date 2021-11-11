<?php

namespace App\Imports;

use App\Student;
use App\Major;
use App\Semester;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Student([
            'id'=>$row['student_id'],
            'student_id'=>$row['student_id'],
            'name' =>$row['name'],
            'major_id'=>Major::where('name',$row['major'])->first()->id,
            'semester_id'=>$row['semester']
        ]);
    }
}
