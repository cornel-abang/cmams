<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dhis extends Model
{
    protected $fillable =['indicator','tag', 'sn', 'special', 'not_greater_than', 'validation_text'];
}
