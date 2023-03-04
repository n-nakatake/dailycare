<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Excretion extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    public static $rules = [
        'resident_id' => 'required|exists:residents,id',
        'user_id' => 'required|exists:users,id',
        'excretion_date' => 'required|date_format:Y-m-d',
        'excretion_time' => 'required|date_format:H:i',
        'excretion_flash' => 'required_without:excretion_dump',
        'excretion_dump' => 'required_without:excretion_flash',
        'excretion_note' => 'nullable|max:2000',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
    
}
