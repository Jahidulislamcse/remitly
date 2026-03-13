<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenualPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'gateway',
        'number',
        'routing_number',
        'account_number',
    ];

     public function cashInCashOut()
    {
        return $this->hasMany(CashInCashOut::class, 'account_id');
    }



}
