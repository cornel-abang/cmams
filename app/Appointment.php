<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['email', 'clientID', 'type', 'appt_date'];

    public function caseManager()
    {
    	return $this->belongsTo(Manager::class,'email','email');
    }

    public function client()
    {
    	return $this->belongsTo(Patient::class, 'clientID','clientID');
    }
}
