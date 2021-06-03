<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
    	'hospital_num',  
            'status',       
            'name',         
            'p_identifier',          
            'facility_hospital_number' ,
            'p_unique_identifier',  
            'sex',          
            'date_of_birth', 
            'facility',      
    ];
}
