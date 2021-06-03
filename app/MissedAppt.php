<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissedAppt extends Model
{
    Protected $hidden = ['id', 'appt_type', 'created_at', 'updated_at'];
}
