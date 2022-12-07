<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    
}
