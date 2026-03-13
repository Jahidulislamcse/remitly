<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function gateway()  
    {
        return $this->belongsTo(Account::class, 'gateway_id', 'id');
    }

    public function status(){

        if($this->status == 0){
            return '<span class="badge rounded-pill text-bg-warning">Pending</span>';
        }else if($this->status == 1){
            return '<span class="badge rounded-pill text-bg-success">Approved</span>';
        }else if($this->status == 2){
            return '<span class="badge rounded-pill text-bg-danger">Rejected</span>';
        }else{
            return '<span class="badge rounded-pill text-bg-primary">Unknown</span>';
        }

    }


}
