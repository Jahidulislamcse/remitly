<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //

    public function index()
    {

        if (auth()->user()->role == 'super admin') {
            $lists = Order::latest()->get();
        } else {
            $lists = Order::latest()->where('customer_id', auth()->user()->id)->get();
            
        }

        return view('backend.order.index', compact('lists'));
    }

    public function orderNow(){

        return view('frontend.order_now');
    }
    public function orderEdit($id){

        
        return view('frontend.order_now',compact('id'));
    }
    public function orderPay($id){

        $data = Order::find($id);

        return view('frontend.payment',compact('data'));
    }

    public function paymentStore(Request $request){

        $request->validate([
            'payment_method' => 'required',
            'paid' => 'required',
            'payment_screenshot' => 'required',
        ]);

        $data = Order::find($request->id);
      
        $data->payment_option = $request->payment_method ;
        if($request->hasFile("payment_screenshot")){
            $data->screenshot = imageUpload($request->payment_screenshot)  ;
        }
        $data->payment_date = date('Y-m-d') ;        
        $data->payment_status = 'paid' ;
        $data->paid = $request->paid ;
        $data->save();

        return redirect()->route('order.status.check',$request->id)->with(['response' => true, 'msg' => 'Order Payment Success']);
    }

    public function orderStatus($id){

        $data = Order::find($id);

        return view('frontend.order-status',compact('data'));
    }


      public function delivered()
    {

        if (auth()->user()->role == 'super admin') {
            $lists = Order::where('status',2)->get();
        } else {
            $lists = Order::where('status',2)->where('customer_id', auth()->user()->id)->get();
            
        }

        return view('backend.order.index', compact('lists'));
    }
    
      public function cancel()
    {

        if (auth()->user()->role == 'super admin') {
            $lists = Order::where('status',3)->get();
        } else {
            $lists = Order::where('status',3)->where('customer_id', auth()->user()->id)->get();
            
        }

        return view('backend.order.index', compact('lists'));
    }

 

    /**
     * Undefined function
     * 
     * @return Type Returns data of type Type
     */
    public function invoice($id='') 
    {

        if (auth()->user()->role == 'customer') {
            $data = Order::where('customer_id',auth()->user()->id)->where('id',$id)->first();
        }else{
            $data = Order::find($id);
        }
        


        return view('backend.order.invoice', compact('id','data'));


    }

    public function status($id,$value){

        $data = Order::find($id);
        $data->status = $value ;
        if ($data->save()) {
            return redirect(route('order.index'))->with(['response' => true, 'msg' => 'Order Status Change Success']);
        } else {
            return redirect(route('order.index'))->with(['response' => false, 'msg' => 'Order Status Change Fail!']);
        }

    }

    public function delete($id){

        $data = Order::find($id);
       
        if ($data->delete()) {
            return redirect(route('order.index'))->with(['response' => true, 'msg' => 'Order delete Success']);
        } else {
            return redirect(route('order.index'))->with(['response' => false, 'msg' => 'Order delete Fail!']);
        }

    }
}
