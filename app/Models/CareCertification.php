<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class CareCertification extends Model
{
    use HasFactory;

    protected $guarded = array('id');
    
    public const LEVELS = [
        1 => '要介護１',  
        2 => '要介護２',  
        3 => '要介護３',  
        4 => '要介護４',  
        5 => '要介護５',  
        6 => '要支援１',  
        7 => '要支援２',  
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
    
}
