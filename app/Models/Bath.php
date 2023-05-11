<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Bath extends Model
{
    use HasFactory;
    
    public const BATH_METHODS = [
        '1' => '一般浴',
        '2' => 'シャワー浴',
        '3' => 'ストレッチャー浴',
        '4' => '機械浴',
        '5' => '清拭',
        '6' => '陰洗',
        '7' => 'その他',
    ];

    protected $guarded = array('id');

    public static $rules = [
        'resident_id' => 'required|exists:residents,id',
        'user_id' => 'required|exists:users,id',
        'bath_date' => 'required|date_format:Y-m-d|before_or_equal:today',
        'bath_time' => 'required|date_format:H:i',
        'bath_method' => 'required|in:1,2,3,4,5,6,7',
        'bath_note' => 'nullable|max:2000',
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
