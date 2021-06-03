<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DhisDaily extends Model
{
    protected $fillable = [
            'indicator',
            'facility',
            'f_m_l15',
            'f_m_g15',
            'f_f_l15',
            'f_f_g15',
            'c_m_l15',
            'c_m_g15',
            'c_f_l15',
            'c_f_g15',
    ];
}
