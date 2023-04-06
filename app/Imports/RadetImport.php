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
            'last_pickup_date'     => Carbon::parse('2022-11-19 11:08:49'),
            'months_of_refil'      => $row['months_of_arv_refill'],
            'facility'             => $row['facility'],
            'date_of_viral_load'   => Carbon::parse('2022-08-19 11:08:49'),
            'tpt_in_the_last_2_years' => 'Yes',
            // 'tpt_in_the_last_2_years' => $row['tpt_in_the_last_2_years'],
            // 'if_yes_to_tpt_date_of_tpt_start_yyyy_mm_dd'=> Carbon::parse($row['if_yes_to_tpt_date_of_tpt_start_yyyy_mm_dd']),
            'if_yes_to_tpt_date_of_tpt_start_yyyy_mm_dd'=> Carbon::now(),
            'art_start_date'        => Carbon::parse('2022-09-19 11:08:49'),
            'art_status'            => $row['current_art_status'],
            'date_of_current_viral_load' => Carbon::parse('2022-10-19 11:08:49'),
            'case_manager'         => $row['case_manager'],
            'current_viral_load'   => $row['current_viral_load_cml'],
            'regimen_at_art_start' => $row['regimen_at_art_start']?$row['regimen_at_art_start']:null,
            'current_regimen'      => $row['current_art_regimen']?$row['current_art_regimen']:null,
            'last_vl_result'       => Carbon::parse('2022-12-02 11:08:49'),
            // 'created_at'           => Carbon::parse('2021-04-19 11:08:49')
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
