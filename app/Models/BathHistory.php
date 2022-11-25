<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BathHistory extends Model
{
    use HasFactory;
    
    public static $rules = array(
        'bath_id' => 'required',
        'edited_at' => 'required',
    );    
}
