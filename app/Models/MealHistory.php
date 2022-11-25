<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealHistory extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    public static $rules = array(
        'meal_id' => 'required',
        'edited_at' => 'required',
    );
}
