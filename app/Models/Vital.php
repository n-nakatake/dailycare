<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vital extends Model
{
    use HasFactory;
    
    protected $guarded = array('id');

    public static $rules = array(
        'resident_id' => 'required',
        'user_id' => 'required',
        'vital_time' => 'required',
        'vital_kt' => 'required_without:vital_bp_u',
        'vital_bp_u' => 'required_with:vital_bp_d',
        'vital_bp_d' => 'required_with:vital_bp_u',
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
