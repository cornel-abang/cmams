<?php

namespace App\Imports;
ini_set('max_execution_time', 0);
use App\Patient;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PatientsImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        return new Patient([
            'hospital_num'  => $row['hospital_num'],
            'sex'           => $row['sex'],
            'status'        => $row['current_art_status'],
            'case_manager'  => $row['case_manager'],
            'facility'      => $row['facility']
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}

//for duplicate hospital_num, concatenate the the facility name and the hospital_num
