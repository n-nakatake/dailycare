<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Resident extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    public static $rules = array(
        'last_name' => 'required',
        'first_name' => 'required',
        'last_name_k' => ['required', 'regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',],
        'first_name_K' => ['required', 'regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',],
        'birthday' => 'required',
        'gender' => 'required',
        'level' => 'required',
        'level_start' => 'required',
        'level_end' => 'required',
    );

    // Modelに関連付けを行う
    public function histories()
    {
        return $this->hasMany('App\Models\ResidentHistory');
                              
    }    
    
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
}
