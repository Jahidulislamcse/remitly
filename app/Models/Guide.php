<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use HasFactory;

    protected $fillable = [
        'mobile_deposit', 'bank_deposit', 'loan', 'remittance','customer_care','cash_pickup',
        'how_to_balance_add', 'how_to_bank_transfer', 'how_to_mobile_banking', 'about_us', 'mobile_menual_deposit'
    ];

}
