<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
    	'hospital_num', 'sex', 
    	'status', 'case_manager',
    	'facility'
    ];
}
