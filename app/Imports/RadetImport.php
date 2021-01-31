<?php

namespace App\Imports;
ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');

use App\Radet;
use \Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class RadetImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        return new Radet([
            'client_hospital_num'  => $row['hospital_num']?$row['hospital_num']:'None',
            'last_pickup_date'     => Carbon::parse($row['last_pickup_date_yyyy_mm_dd']),
            'months_of_refil'      => $row['months_of_arv_refill'],
            'facility'             => $row['facility'],
            'date_of_viral_load'   => Carbon::parse($row['date_of_viral_load_sample_collection_yyyy_mm_dd']),
            'tpt_in_the_last_2_years' => $row['tpt_in_the_last_2_years'],
            'if_yes_to_tpt_date_of_tpt_start_yyyy_mm_dd'=> Carbon::parse($row['if_yes_to_tpt_date_of_tpt_start_yyyy_mm_dd']),
            // 'tpt_completion_date_yyyy_mm_dd' => Carbon::parse($row['tpt_completion_date_yyyy_mm_dd']),
            'art_start_date'        => Carbon::parse($row['art_start_date_yyyy_mm_dd']),
            'art_status'            => $row['current_art_status'],
            'date_of_current_viral_load' => Carbon::parse($row['date_of_current_viral_load_yyyy_mm_dd']),
            'case_manager'         => $row['case_manager'],
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
