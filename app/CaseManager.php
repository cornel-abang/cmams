<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseManager extends Model
{
    protected $fillable =['name','facility_id','profile_photo','email','phone'];

    public function facility()
    {
    	return $this->belongsTo(Facility::class);
    }

    public function clients()
    {
    	return $this->hasMany(Client::class);
    }

    public function reports()
    {
    	return $this->hasMany(Report::class);
    }

    public function performance()
    {
        return $this->hasMany(Performance::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class,'email','email');
    }
}
