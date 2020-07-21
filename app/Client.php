<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
    						'ClientID',
    						'name',
    						'phone',
    						'opc_phone',
    						'address',
    						'facility_id',
    						'case_manager_id',
    						'status',
                            'clientID'
    					];
    public function facility()
    {
    	return $this->belongsTo(Facility::class);
    }

    public function caseManager()
    {
    	return $this->belongsTo(CaseManager::class);
    }
}
