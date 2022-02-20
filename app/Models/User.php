<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'status',
        'password',
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

    public function getRules($method){
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'status' => 'required|in:active,inactive,deleted',
            'email' => 'required|unique:users,email,'.$this->id
        ];
        if($method === 'store'){
            $rules['username'] = 'required|unique:users';
            $rules['email'] = 'required|unique:users';
            $rules['password'] = 'required|min:6|confirmed';
        }

        if($method === 'update'){
            $rules['id'] = 'required';
        }

        return $rules;
    }
}
