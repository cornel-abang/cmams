<?php

namespace App\Imports;
ini_set('max_execution_time', 0);
use App\PatientList;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PatientsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        dd($row);
        return PatientList::Create([
            'hospital_num'  => $row['hospital_num'],
            'status'        => 'Active',
            'name'          => $row['surname'].' '.$row['other_names'],
            'facility_hospital_number' => $row['facility_hospital_number'],
            'sex'           => $row['sex'],
            'date_of_birth' => \Carbon\Carbon::parse($row['date_of_birth_yyyy_mm_dd']),
            'facility'      => $row['facility'] ? $row['facility'] : 'None'
        ]);
    }

    // public function batchSize(): int
    // {
    //     return 100;
    // }

    // public function chunkSize(): int
    // {
    //     return 100;
    // }
}

//for duplicate hospital_num, concatenate the the facility name and the hospital_num
