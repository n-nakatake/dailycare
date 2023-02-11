<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Attendance extends Model
{
    use HasFactory;
    
    public const ATTENDANCE_TYPE_DAY_SHIFT = 1;
    public const ATTENDANCE_TYPE_NIGHT_SHIFT = 2;

    protected $guarded = array('id');

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
