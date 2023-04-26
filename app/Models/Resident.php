<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class Resident extends Model
{
    use HasFactory;

    protected $guarded = array('id');



    // Modelに関連付けを行う
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
    
    public function existOnly()
    {
        return $this->where(function($query){
                        $query->orWhere('left_date', 'is', null)
                              ->orWhere('left_date', '>=', Carbon::now());
                    });
    }
    
    /**
     * 退所していない入居者のみをアイウエオ順で取得する
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExist()
    {
        return $this
            ->where('office_id', Auth::user()->office_id)
            ->where(function($residentQuery){
                $residentQuery->whereNull('left_date')
                    ->orWhere('left_date', '>=', Carbon::now());
            })
            ->orderBy('last_name_k')
            ->orderBy('first_name_k');
    }
    
    public function getCurrentCareLevelAttribute()
    {
        $careCertification = $this->careCertifications()
            ->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>=', Carbon::now())
            ->first();
        
        return $careCertification ? $careCertification->level : null;
    }
}
