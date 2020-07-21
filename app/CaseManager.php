<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseManager extends Model
{
    protected $fillable =['name','facility_id','profile_photo'];

    public function facility()
    {
    	return $this->belongsTo(Facility::class);
    }

    public function clients()
    {
    	return $this->hasMany(Client::class);
    }
}
