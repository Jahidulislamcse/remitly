<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashInCashOut extends Model
{
    use HasFactory;

    protected $table = 'cash_in_cash_out';

    protected $fillable = [
        'user_id', 'bank_account_id', 'transaction_number', 'sending_phone_number', 'amount','type', 'status', 'withdrawal_phone_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menualPayment()
    {
        return $this->belongsTo(MenualPayment::class, 'bank_account_id');
    }
}
