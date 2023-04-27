<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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

    public static function checkOwner(){
        return (Auth::user()->role == 2);
    }

    public static function checkInvestor(){
        if (empty(Auth::user()->role )){return false;}
        return (Auth::user()->role == 3);
    }

    public static function checkAdmin(){
        if (empty(Auth::user()->role )){return false;}
        return (Auth::user()->role == 1);
    }

    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function getTitle(){
        $title = '';
        if (empty(Auth::user()->role )){return $title;}

        $role_id = Auth::user()->role;
        if ($role_id == 2){
            $title = 'Founder';
        } elseif ($role_id = 3){
            $title = 'Investor';
        }
        return $title;
    }

}
