<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'office_id',
        'last_name',
        'first_name',
        'qualification',
        'user_code',
        'email',
        'password',
        'admin_flag',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
    
/*    public static $rules = [
        'office_id' => ['nullable', 'exists:offices,id',],
        'last_name' => 'required',
        'first_name' => 'required',
    ];    

*/    
    public static $rules = [
        'office_id' => ['nullable', 'exists:offices,id',],
        'last_name' => 'required',
        'first_name' => 'required',
        'qualification' => 'required',
        'user_code' => ['required', 'string', 'min:4', 'max:16', 'unique:users',],
        'password' => ['required', 'string', 'min:8', 'confirmed',],
    ];    

}
