<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $appends = ['must_verify_email', 'name'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Determine if the user is an administrator.
     *
     * @return bool
     */
    public function getMustVerifyEmailAttribute()
    {
        return config('auth.must_verify_email');
    }
   
    public function getNameAttribute() { 
        return $this->first_name . ' ' . $this->last_name;
    }

    public function user_verify()
    {
        return $this->hasOne(UserVerify::class);
    }

    public function partners()
    {
        return $this->belongsToMany(Partner::class, 'partner_users');
    }

    public function getPartnerAttribute()
    {
        return $this->partners()->first();
    }

    public function sendEmailVerificationNotification()
    {
        $user = $this;
        
        $token = \Str::random(64);

        UserVerify::create([
            'user_id' => $user->id, 
            'token' => $token
        ]);

        dispatch(new \App\Jobs\VerifyMailJob($user->email, ['token' => $token, 'user' => $user]));
    }
}
