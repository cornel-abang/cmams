<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable=['name','backstop'];

    // public function caseManagers()
    // {
    // 	return $this->hasMany(CaseManager::class);
    // }

    public function clients()
    {
    	return $this->hasMany(Client::class);
    }
}
