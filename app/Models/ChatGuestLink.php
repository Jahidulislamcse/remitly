<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatGuestLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'avatar',
        'virtual_number',
        'token',
        'country',
        'is_online',
        'subtitle'
    ];
}