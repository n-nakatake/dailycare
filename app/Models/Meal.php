<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    public const MEAL_BLD_OPTIONS = [
        1 => '朝食',
        2 => '昼食',
        3 => '夜食',
    ];

    public const MEAL_INTAKE_OPTIONS = [
        1 => '10%',
        2 => '20%',
        3 => '30%',
        4 => '40%',
        5 => '50%',
        6 => '60%',
        7 => '70%',
        8 => '80%',
        9 => '90%',
        10 => '完食',
    ];

    // Meal Modelに関連付けを行う
    public function mealhistories()
    {
        return $this->hasMany('App\Models\MealHistory');
    } 

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
