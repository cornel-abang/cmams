<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Manager extends Model
{
	protected $fillable = ['names','email','phone','surname', 'facility'];

    public function clients()
    {
    	return Patient::where('case_manager',$this->names)->get();
    }

    public function clientsPaginate()
    {
    	return Patient::where('case_manager', $this->names)->paginate(20);
    }

    public function reports()
    {
    	return $this->hasMany(Report::class);
    }

    public function performances()
    {
        return RadetPerformance::where('case_manager',$this->names)->get();
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class,'email','email');
    }

    public function timesheets()
    {
        return Attendance::where('case_manager',$this->names)->orderBy('created_at','desc')->whereBetween('created_at', 
                        [
                            Carbon::now()->startOfMonth(), 
                            Carbon::now()->endOfMonth()
                        ])->get();
    }
}
