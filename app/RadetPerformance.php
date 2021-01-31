<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RadetPerformance extends Model
{
    protected $fillable = ['case_manager', 'performance'];

    public function indicators()
    {
    	return $this->hasOne(RadetIndicator::class, 'case_manager', 'case_manager');
    }
}
