<?php

namespace App\Http\Controllers;

use App\Models\BillPay;
use Illuminate\Http\Request;
use App\Traits\SendPushNotification;
use App\Notifications\PushNotification;

class BillPayController extends Controller
{
    use SendPushNotification;
    
    public function list()
    {
        $lists = BillPay::orderBy('id', 'desc')->paginate(50);
        return view('backend.bill_pay_list', compact('lists'));
    }
    public function approve($id)
    {
        $recharge = BillPay::findOrFail($id);
        $recharge->status = 1;
        $recharge->save();

        return redirect()->back()->with(['response' => true, 'msg' => 'Bill Pay Approved!']);
    }
    public function reject($id)
    {
        $recharge = BillPay::findOrFail($id);
        $recharge->status = 2;
        $recharge->save();

        $user = $recharge->user;
        $user->balance += $recharge->amount;
        $user->save();

        return redirect()->back()->with(['response' => true, 'msg' => 'Bill Pay Rejected and Amount Refunded!']);
    }

    public function delete($id)
    {
        $transaction = BillPay::findOrFail($id);
        if( $transaction->delete()){
            return redirect()->back()->with(['response' => true, 'msg' => ' Bill Pay Deleted!']);
        }
    }

    public function billpay(Request $request){

        if ($request->post()) {

            $request->validate([
                'operator' => 'required',
                'amount' => 'required|numeric|min:1',
                'mobile' => 'required|numeric|min:10',
                'type' => 'required|in:prepaid,postpaid',
                'company' => 'required|max:191',
            ]);
            
            if( $request->pin != auth()->user()->pin){
                return redirect()->back()->with(['response' => false, 'msg' => 'Invalid Pin code!']);
            }
            if( $request->amount > auth()->user()->balance){
                return redirect()->back()->with(['response' => false, 'msg' => 'Please Topup First!']);
            }
            
        
            $data = new BillPay() ;
            $data->operator = $request->operator ;
            
            $data->amount = $request->amount ;
            $data->mobile = $request->mobile ;
            $data->type = $request->type;
            $data->company = $request->company;
            $data->user_id = auth()->user()->id;
            $data->status = 0 ;

            if ($data->save()) {
                $user = auth()->user();
                $user->balance = $user->balance - $request->amount ;
                $user->save();
                
                $this->sendPush(
                    "বিল পে | WIZE TRANSFER",
                    "{$user->name} {$request->amount} টাকা {$request->company} | {$request->operator} বিল পরিশোধের আবেদন করেছেন"
                );
                
                return redirect(route('success',[$data->id,'billpay']));
            }
             
           

        }

        return view('backend.bill_pay') ;

    }
}