<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    public static $rules = array(
        'resident_last_name' => 'required',
        'resident_first_name' => 'required',
        'resident_last_name_k' => ['required', 'regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',],
        'resident_first_name_K' => ['required', 'regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',],
        'resident_birthday' => 'required',
        'resident_gender' => 'required',
        'resident_level' => 'required',
        'resident_level_start' => 'required',
        'resident_level_end' => 'required',
    );

    // Profile Modelに関連付けを行う
    public function profile_histories()
    {
        return $this->hasMany('App\Models\ProfileHistory');
                              
    }    
    
}
