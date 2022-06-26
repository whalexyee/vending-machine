<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'deposit',
        'role_id',
        'password',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class,'role_id');
    }

    public function buyer()
    {
        $buyer = false;
        if ($this->role_id == 1) {
            $buyer = true;
        }
        return $buyer;
    }

    public function seller()
    {
        $seller = false;
        if ($this->role_id == 2) {
            $seller = true;
        }
        return $seller;
    }

    public function totalSpent()
    {
        $spent = 0;
        $spent = UserProductPurchase::where('user_id',$this->id)->sum('price');
        return $spent;
    }

    

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
}
