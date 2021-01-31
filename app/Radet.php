<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Radet extends Model
{
    protected $fillable = [
    	'client_hospital_num', 'last_pickup_date', 'case_manager',
    	'months_of_refil', 'facility', 'date_of_viral_load','tpt_in_the_last_2_years',
    	'tpt_completion_date_yyyy_mm_dd','if_yes_to_tpt_date_of_tpt_start_yyyy_mm_dd',
    	'art_start_date', 'art_status', 'date_of_current_viral_load','created_at'
    ];
}
