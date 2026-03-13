<?php

namespace App\Livewire;

use App\Models\Order as ModelsOrder;
use App\Models\OrderItem;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Order extends Component
{

    public $links = [];
    public $id ;
    public $subtotal;
    public $total;
    public $tax;
    public $pay_method = "COD";

    public function mount()
    {
        if($this->id){
            $this->loadData() ;
        }else{
            $this->links = [
                ['link' => '', 'quantity' => null,'size' => '', 'color' => '', 'other' => '', 'coupon' => '', 'shade' => '', 'comment' => '', 'price' => null, 'shipping' => null, 'bdt' => ''],
            ];
        }
       
    }

    public function loadData(){

        $order = ModelsOrder::find($this->id) ;
     
        $this->subtotal = $order->subtotal ;
        $this->total = $order->total ;
        $this->tax = $order->tax ;
       
        foreach($order->items  as  $item ){
            $this->links[]  = ['link' => $item->link , 'quantity' => $item->qty , 'size' => $item->size , 'color' => $item->color , 'other' => $item->other , 'coupon' => $item->coupon , 'shade' => $item->shade , 'comment' => $item->comment , 'price' => $item->price , 'shipping' => $item->shipping , 'bdt' =>$item->bdt ] ;
           
        }
     

    }

    public function addLink()
    {
        $this->links[] = ['link' => '', 'quantity' => null, 'size' => '', 'color' => '', 'other' => '', 'coupon' => '', 'shade' => '', 'comment' => '', 'price' => null, 'shipping' => null, 'bdt' => ''];
    }

    public function price_convert($index = null)
    {

        $data = $this->links[$index];
        $usd_rate = @siteInfo()->usd_rate ?: 0;
        $qty = $data['quantity'] ?: 0;
        $price = $data['price'] ? $data['price'] * $qty : 0;
        $shipping = $data['shipping'] ?: 0;
        $bdt = ($price + $shipping) * @$usd_rate;

        $this->links[$index]['bdt'] = $bdt;
        $this->total_cal();
    }

    public function total_cal()
    {
        $total = 0;
        foreach ($this->links as $link) {

            $total += $link['bdt'];
        }

        $this->subtotal = $total;
        $this->tax = ($total * 8.8) / 100;
        $this->total = $this->subtotal + $this->tax;
    }

    public function removeLink($index)
    {
        unset($this->links[$index]);
        $this->links = array_values($this->links);
    }
    public function render()
    {
        return view('livewire.order');
    }


    public function place_order()
    {

        if (!auth()->check())
            return redirect()->route('user.login');

        if (!$this->total ||  $this->total == null)
            return  $this->dispatch('msg', ' Input Data First ');

        if ($this->links) {
            if($this->id){
                $order = ModelsOrder::find($this->id);

            }else{
                $order = new ModelsOrder();
                $order->invoice_no = $order->code();
                $order->customer_id = auth()->user()->id;
            }

            $order->subtotal = $this->subtotal;
            $order->tax = $this->tax;
            $order->total = $this->total;

            if ($order->save()) {

                if($this->id){
                    $order->items()->delete() ;
                }

                foreach ($this->links  as $link) {
                    $orderItem = new OrderItem();

                    $orderItem->order_id = $order->id;
                    $orderItem->link = $link['link'];
                    $orderItem->qty = $link['quantity'];
                    $orderItem->size = $link['size'];
                    $orderItem->color = $link['color'];
                    $orderItem->other = $link['other'];
                    $orderItem->shade = $link['shade'];
                    $orderItem->comment = $link['comment'];
                    $orderItem->coupon = $link['coupon'];
                    $orderItem->price = $link['price'];
                    $orderItem->shipping = $link['shipping'];
                    $orderItem->bdt = $link['bdt'];
                    if ($orderItem->save()) {
                        $this->links = [
                            ['link' => '','quantity' => null, 'size' => '', 'color' => '', 'other' => '', 'coupon' => '', 'shade' => '', 'comment' => '', 'price' => null, 'shipping' => null, 'bdt' => ''],
                        ];
                        $this->subtotal = null;
                        $this->tax = null;
                        $this->total = null;
                    }
                }

            if(!$this->id){
                $username = auth()->user()->name;
                $phone = auth()->user()->phone;
                $order_no = $order->invoice_no;
                if ($phone) {
                    $request_data = [
                        "msg" => "Dear $username, your order no is- $order_no. Thanks for helping us serve you better! Moono Express",
                        "to" => '88' . $phone,
                        "api_key" => "08Zm8HiG9H9cldxBsoVx62Ej4SbvdYy2JPfX25m2",
                    ];
                    $response = Http::get("https://api.sms.net.bd/sendsms", $request_data);
                    $response = json_decode($response);
                   
                }
                $this->dispatch('msg', "Order place success");

                return redirect()->route('order.pay', $order->id);
            }else{
                $this->dispatch('msg', "Order Save success");

                return redirect()->route('order.index');
            }


               
            }
        } else {
            return  $this->dispatch('msg', ' Input Data First ');
        }
    }
}
