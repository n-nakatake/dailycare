<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vital extends Model
{
    use HasFactory;
    
    protected $guarded = array('id');

    public static $rules = array(
        'resident_id' => 'required|exists:residents,id',
        'user_id' => 'required|exists:users,id',
        'vital_date' => 'required|date_format:Y-m-d',
        'vital_time' => 'required|date_format:H:i',
        'vital_kt' => 'nullable|required_without:vital_bp_u,vital_bp_d|numeric',
        'vital_bp_u' => 'nullable|required_without:vital_kt|required_with:vital_bp_d|integer',
        'vital_bp_d' => 'nullable|required_without:vital_kt|required_with:vital_bp_u|integer',
        'vital_hr' => 'nullable|integer',
        'vital_height' => 'nullable|numeric',
        'vital_weight' => 'nullable|numeric',
        'vital_note' => 'nullable|max:2000',
        'image' => 'nullable|file|mimes:jpeg,jpg,png|max:3000',
     );    

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    // Vital Modelに関連付けを行う
    public function histories()
    {
        return $this->hasMany('App\Models\History');
    }     
}
