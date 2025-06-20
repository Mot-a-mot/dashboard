<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExerciseAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exercice_id',
        'score',
        'is_passed',
        'note',
        'submitted_at',
    ];

    protected $casts = [
        'is_passed' => 'boolean',
        'submitted_at' => 'datetime',
    ];

    // Relationships

    // ✅ Belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ Belongs to Exercice
    public function exercice()
    {
        return $this->belongsTo(Exercice::class);
    }
}
