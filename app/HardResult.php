<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HardResult extends Model
{
   protected $fillable = [
    	'facility',
        'pepfar_id',
        'hospital_num',
        'result',
        'fac_hosp_id'
    ];
}
