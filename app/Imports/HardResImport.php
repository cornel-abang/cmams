<?php

namespace App\Imports;

use App\HardResult;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class HardResImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new HardResult([
            'facility'     => $row['facility_name'],
            'pepfar_id'    => $row['pepfarid'],
            'hospital_num' => $row['hospital_id'],
            'result'       => $row['result'],
            'fac_hosp_id'  => $row['facility_name'].'/'.$row['hospital_id'],
        ]);
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
