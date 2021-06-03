<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientList extends Model
{
    protected $fillable = [
    	'hospital_num',  
            'status',       
            'name',            
            'facility_hospital_number' ,
            'sex',          
            'date_of_birth', 
            'facility',      
    ];
}
