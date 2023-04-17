<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;


class Resident extends Model
{
    use HasFactory;

    protected $guarded = array('id');



    // Modelに関連付けを行う
/*    public function histories()
    {
        return $this->hasMany('App\Models\ResidentHistory');
                              
    }*/    

    public function vitals()
    {
        return $this->hasMany('App\Models\Vital');
    }
    
    public function meals()
    {
        return $this->hasMany('App\Models\Meal');
    }
    
    public function baths()
    {
        return $this->hasMany('App\Models\Bath');
    }
    
    public function excretions()
    {
        return $this->hasMany('App\Models\Excretion');
    }
    
    public function careCertifications()
    {
        return $this->hasMany('App\Models\CareCertification');
    }
    
    public function getCurrentCareCertificationAttribute()
    {
        return $this->careCertifications()
            ->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>=', Carbon::now())
            ->first();
    }
}
