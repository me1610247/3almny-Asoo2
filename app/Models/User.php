<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'phone_verified_at',
        'phone_verify_code',
        'phone_attempts_left',
        'phone_last_attempt_date',
        'phone_verify_code_sent_at',
    ];
    public function trainer()
{
    return $this->hasOne(Trainer::class);
}
public function courses()
{
    return $this->hasMany(Course::class, 'trainer_id');
}
public function session()
{
    return $this->hasMany(Session::class, 'trainer_id');
}
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'phone_verify_code',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'phone_verified_at' => 'datetime',
            'phone_verify_code_sent_at' => 'datetime',
            'phone_last_attempt_date' => 'datetime',

        ];
    }
    public function sessions()
{
    return $this->hasMany(Session::class); // Adjust with actual session model name
}

public function applications()
{
    return $this->hasMany(SessionApplication::class); // Adjust with actual application model name
}
}
