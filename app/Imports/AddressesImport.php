<?php

namespace App\Imports;

use App\Address;
use App\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class AddressesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Address([
            'addressable_id'=>$row['student_id'],
            'addressable_type'=>'App\Student',
            'country' =>$row['country'],
            'city'=>$row['city'],
            'street' =>$row['street']
        ]);
    }
}
