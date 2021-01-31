<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RadetIndicator extends Model
{
    protected $fillable = [
    	'refill',
        'refill_exp',
        'refill_met',
        'refill_pc',
        'vlc',
        'vlc_exp',
        'vlc_met',
        'vlc_pc',
        'tpt_exp',
        'tpt_met',
        'tpt_pc',
        'attendance',
        'case_manager'
    ];
}
