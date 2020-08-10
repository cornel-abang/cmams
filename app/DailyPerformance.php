<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyPerformance extends Model
{
    protected $fillable= [
    			'refill_performance',
                'attendance_performance',
                'viral_load_performance',
                'ict_performance',
                'tpt_performance',
                'tracking_performance'
    ];
}
