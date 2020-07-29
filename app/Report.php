<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable=[
    						'case_manager_id',
    						'attendance',
    						'refill_deno',
                            'refill_numo',
    						'viral_load_deno',
                            'viral_load_numo',
    						'ict_deno',
                            'ict_numo',
    						'tpt_deno',
                            'tpt_numo',
    						'comment',
    						'tag'
    					];

    public function caseManager()
    {
    	return $this->belongsTo(CaseManager::class);
    }
}
