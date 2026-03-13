<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    public function topups()
    {
        return $this->hasMany(Topup::class, 'gateway_id', 'id');
    }
}
