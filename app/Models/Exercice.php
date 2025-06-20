<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exercice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'niveau_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships

    // ✅ Belongs to Niveau
    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    // ✅ Has many UserExerciseAttempt
    public function userExerciseAttempts()
    {
        return $this->hasMany(UserExerciseAttempt::class);
    }
}
