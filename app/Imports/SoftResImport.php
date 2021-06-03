<?php

namespace App\Imports;

use App\SoftResult;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class SoftResImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SoftResult([
            'facility'     => $row['facfromname'],
            'pepfar_id'    => $row['pepfar_id'],
            'hospital_num' => $row['hospitalno'],
            'result'       => $row['result'],
            'fac_hosp_id'  => $row['facfromname'].'/'.$row['hospitalno']
        ]);
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
