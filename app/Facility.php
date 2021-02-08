<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable=['name','backstop'];

    public function caseManagers()
    {
    	return Manager::where('facility', $this->name)->get();
    }

    public function clients()
    {
    	return Patient::where('facility',$this->name)->get();
    }

    public function clientsPaginate()
    {
    	return Patient::where('facility', $this->name)->paginate(20);
    }
}
