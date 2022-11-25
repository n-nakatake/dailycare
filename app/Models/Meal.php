<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    public static $rules = array(
        'meal_rocorder' => 'required',
        'meal_time' => 'required',
     );    

    // Meal Modelに関連付けを行う
    public function mealhistories()
    {
        return $this->hasMany('App\Models\MealHistory');
    } 
    
}
