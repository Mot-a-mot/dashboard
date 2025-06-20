<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Niveau extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',      // e.g., A1, A2, B1...
        'order',     // progression order
    ];
    public function users()
    {
        return $this->hasMany(User::class, 'current_niveau_id');
    }
}
