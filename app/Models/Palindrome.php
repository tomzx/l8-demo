<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Palindrome extends Model
{
    use HasFactory;

    protected $attributes = [
        'text' => null,
        'is_palindrome' => false,
    ];

    protected $casts = ['is_palindrome' => 'boolean'];

    protected $fillable = ['text', 'is_palindrome'];
}
