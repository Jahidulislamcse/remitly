<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Summery extends Model
{
    use HasFactory;


    public static function order(){
        if(auth()->user()->role == 'customer'){
            return Order::where('customer_id',auth()->user()->id)->latest();
        }else{
            return Order::latest();
        }
       
    }




}
