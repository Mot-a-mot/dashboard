<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'email',
        'photo_url',
        'level',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    // Enable timestamps
    public $timestamps = true;
}
