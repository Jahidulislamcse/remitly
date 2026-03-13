<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remittance extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'operator',
        'amount',
        'account',
        'branch',
        'achold',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status(): string
    {
        return match ((int) $this->status) {
            1 => '<span class="badge bg-success">Approved</span>',
            2 => '<span class="badge bg-danger">Rejected</span>',
            default => '<span class="badge bg-warning text-dark">Pending</span>',
        };
    }
}
