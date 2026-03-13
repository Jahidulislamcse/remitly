<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function code(){

        $total_cat = Order::all()->count();
        $total =  $total_cat + 1 ;
        $cat_code = 'Inv-'.str_pad($total,4,0,STR_PAD_LEFT) ;

        return $cat_code ;

    }

    public function items(){
        return $this->hasMany(OrderItem::class,'order_id') ;
    }


    public function customer(){
        return $this->belongsTo(User::class,'customer_id') ;
    }
    
    public function status(){
        if($this->status == 1){
            return 'Final' ;
        }elseif($this->status == 2){
            return 'Delivered' ;
        }elseif($this->status == 3){
            return 'Cancel' ;
        }
        elseif($this->status == 0){
            return 'Pending' ;
        }
        elseif($this->status == 4){
            return 'In-Transit' ;
        }
        elseif($this->status == 5){
            return 'Picked' ;
        }
        elseif($this->status == 6){
            return 'Processing' ;
        }else{
            return 'Processing' ;
        }
    }

    public function advanceAmount(){

        $advance = ( $this->total / 100 )* 80 ;
        return $advance ;
    }

}
