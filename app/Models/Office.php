<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Office extends Model
{
    use HasFactory;
    
    protected $guarded = array('id');
}
