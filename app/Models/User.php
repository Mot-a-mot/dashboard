<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'current_niveau_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Belongs to Niveau
    public function currentNiveau()
    {
        return $this->belongsTo(Niveau::class, 'current_niveau_id');
    }

    // Has many UserExerciseAttempt
    public function userExerciseAttempts()
    {
        return $this->hasMany(UserExerciseAttempt::class);
    }
}
