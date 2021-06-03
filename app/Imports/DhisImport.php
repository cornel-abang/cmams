<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Dhis;

class DhisImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
    	// dd($row);
        return new Dhis([
            'indicator' => $row['data_elements'],
            'tag'  => $row['tag'],
            'special' => $row['special'],
            'sn' => $row['sn'],
            'not_greater_than' => $row['not_greater_than'],
            'validation_text' => $row['validation_text'],
        ]);
    }

    public function batchSize(): int
    {
        return 50;
    }

    public function chunkSize(): int
    {
        return 50;
    }
}
