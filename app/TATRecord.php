<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TATRecord extends Model
{
    protected $fillable = [
    		'facility',                 
            'patient_name',             
            'lab_no',                    
            'hospital_no',               
            'sex',                 
            'age',                  
            'test_type' ,               
            'eid_res',                   
            'vl_res',                    
            'gene_xpert_res',           
            'date_test_requested',     
            'tat_1',                    
            'date_sample_collected',  
            'tat_2' ,                    
            'sample_pickup_date',       
            'sample_trans_pick_by',     
            'date_sample_rec_at_lab',   
            'tat_3',                    
            'name_of_rec_testing_lab',   
            'date_samples_tested_assay_test',
            'tat_4',                     
            'date_res_released_to_facility',
            'tat_5',                     
            'date_res_reci_at_clinic',   
            'tat_6',                    
            'date_res_entered_into_med_record', 
            'tat_7',                    
            'date_patient_notified-res_ready', 
            'tat_8',                     
            'date_res_given_to_patient', 
            'overall_tat',              
            'remarks'      
    ];
}
