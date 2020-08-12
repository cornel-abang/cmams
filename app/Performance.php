<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    protected $fillable = ['case_manager_id','performance'];

    public function caseManager()
    {
    	return $this->belongsTo(Casemanager::class);
    }
}
