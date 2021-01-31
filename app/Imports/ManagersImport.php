<?php

namespace App\Imports;

use App\Manager;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ManagersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
       if (!empty($row['name'])) {
            return Manager::Create([
                'names'     => $row['name'],
                'facility'  => $row['facility'],
                'email'     => $row['email'],
                'phone'     => $row['phone_number']
            ]);
       }
    }
}
