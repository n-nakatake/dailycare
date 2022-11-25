<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vital extends Model
{
    use HasFactory;
    
    protected $guarded = array('id');

    public static $rules = array(
        'vital_rocorder' => 'required',
        'vital_time' => 'required',
     );    

    // Vital Modelに関連付けを行う
    public function histories()
    {
        return $this->hasMany('App\Models\History');
    }     
}
