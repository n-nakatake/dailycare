<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    public const QUALIFICATIONS = [
        1 => '介護福祉士',
        2 => '初任者研修修了',
        3 => 'ヘルパー2級',
        4 => 'ヘルパー1級',
        5 => '介護支援専門員',
        6 => 'なし',
    ] ;

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
        'retirement_date',
        'retirement_note',
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
    
    public static $rules = [
        'office_id' => ['nullable', 'exists:offices,id',],
        'last_name' => 'required',
        'first_name' => 'required',
        'qualification' => 'required',
        'user_code' => ['required', 'string', 'min:4', 'max:16', 'unique:users',],
        'password' => ['required', 'string', 'min:8', 'confirmed',],
    ];    

    /**
     * 退所していない職員のみをid順で取得する
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExist($query)
    {
        return $query
            ->where('office_id', Auth::user()->office_id)
            ->where(function($userQuery){
                $userQuery->whereNull('retirement_date')
                    ->orWhere('retirement_date', '>=', Carbon::now());
            })
            ->orderBy('id');
    }

}
