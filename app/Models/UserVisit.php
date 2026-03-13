<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVisit extends Model
{
    protected $fillable = [
        'user_id',
        'ip',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}