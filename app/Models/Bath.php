<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bath extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    public static $rules = array(
        'resident_id' => 'required',
        'user_id' => 'required',
        'bath_time' => 'required',
        'bath_method' => 'required',
     );    

    // Bath Modelに関連付けを行う
    public function bathhistories()
    {
        return $this->hasMany('App\Models\BathHistory');
    } 
    
}
