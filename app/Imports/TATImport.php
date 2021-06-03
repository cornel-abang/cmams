<?php

namespace App\Imports;

use App\TATRecord;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class TATImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        return new TATRecord([
            'facility'                  => 'University of Calabar Teaching Hospital',
            'patient_name'              => $row['patients_name'],
            'lab_no'                    => $row['lab_no'],
            'hospital_no'               => $row['hospital_no'],
            'sex'                       => $row['sex'],
            'age'                       => $row['age'],
            'test_type'                 => $row['test_eid_vl_cd4_gene_xpert'],
            'eid_res'                   => $row['eid_results_negpos'],
            'vl_res'                    => $row['vl_result_copiesml'],
            'gene_xpert_res'            => $row['gene_xpert_negpos'],
            'date_test_requested'       => Carbon::parse($row['date_test_requested']),
            'tat_1'                     => $row['tat_1_in_days'],
            'date_sample_collected'     => Carbon::parse($row['date_sample_collected']),
            'tat_2'                     => $row['tat_2_in_days'],
            'sample_pickup_date'        => Carbon::parse($row['sample_pick_up_date']),
            'sample_trans_pick_by'      => $row['sample_transportedpicked_up_by'],
            'date_sample_rec_at_lab'    => Carbon::parse($row['date_sample_recieved_at_lab']),
            'tat_3'                     => $row['tat_3_in_days'],
            'name_of_rec_testing_lab'   => $row['name_of_recievingtesting_laboratory'],
            'date_samples_tested_assay_test'=> Carbon::parse($row['date_samples_testedassay_date']),
            'tat_4'                     => $row['tat_4_in_days'],
            'date_res_released_to_facility'=> Carbon::parse($row['date_result_released_to_facility']),
            'tat_5'                     => $row['tat_5_in_days'],
            'date_res_reci_at_clinic'   => Carbon::parse($row['date_result_recieved_at_clinic']),
            'tat_6'                     => $row['tat_6_in_days'],
            'date_res_entered_into_med_record' => Carbon::parse($row['date_result_entered_into_medical_record']),
            'tat_7'                     => $row['tat_7_in_days'],
            'date_patient_notified-res_ready' => Carbon::parse($row['date_patient_notified_result_is_ready']),
            'tat_8'                     => $row['tat_8_in_days'],
            'date_res_given_to_patient' => Carbon::parse($row['date_result_given_to_patient']),
            'overall_tat'               => $row['overall_tat_in_days'],
            'remarks'                   => $row['remarks_sample_rejected_invalidfailed_run'],
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
