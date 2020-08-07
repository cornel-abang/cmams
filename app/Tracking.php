<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $fillable = ['client_id','case_manager_id','evidence','method'];

    public function caseManager()
    {
    	return $this->belongsTo(CaseManager::class);
    }

    public function client()
    {
    	return $this->belongsTo(Client::class);
    }
}
