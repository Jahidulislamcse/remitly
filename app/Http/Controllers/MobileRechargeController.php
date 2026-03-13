<?php

namespace App\Http\Controllers;

use App\Models\MobileRecharge;
use Illuminate\Http\Request;
use App\Notifications\PushNotification;
use App\Traits\SendPushNotification;

class MobileRechargeController extends Controller
{
        use SendPushNotification;

        public function list()
        {
            $lists = MobileRecharge::latest()->paginate(50);
            return view('backend.recharge_list', compact('lists'));
        }

        public function approve($id)
        {
            $recharge = MobileRecharge::findOrFail($id);
            $recharge->status = 1;
            $recharge->save();

            return redirect()->back()->with(['response' => true, 'msg' => 'Recharge Approved!']);
        }

        public function reject($id)
        {
            $recharge = MobileRecharge::findOrFail($id);
            $recharge->status = 2;
            $recharge->save();

            $user = $recharge->user;
            $user->balance += $recharge->amount;
            $user->save();

            return redirect()->back()->with(['response' => true, 'msg' => 'Recharge Rejected and Amount Refunded!']);
        }

        public function delete($id)
        {
            $transaction = MobileRecharge::findOrFail($id);
            if( $transaction->delete()){
                return redirect()->back()->with(['response' => true, 'msg' => ' Recharge Deleted!']);
            }
        }


        public function recharge(Request $request){

            if ($request->post()) {
                // dd($request->post());

                $request->validate([
                    'operator' => 'required',
                    'type' => 'required',
                    'amount' => 'required|numeric|min:1',
                    'mobile' => 'required|numeric|min:10'
                ]);
                 if( $request->pin != auth()->user()->pin){
                return redirect()->back()->with(['response' => false, 'msg' => 'Invalid Pin code!']);
                }
        
                if( $request->amount > auth()->user()->balance){
                    return redirect()->back()->with(['response' => false, 'msg' => 'Please Topup First!']);
                }
            
                $data = new MobileRecharge() ;
                $data->operator = $request->operator ;
                $data->type = $request->type ;
                $data->amount = $request->amount ;
                $data->mobile = $request->mobile ;
                $data->user_id = auth()->user()->id;
                $data->status = 0 ;

                if ($data->save()) {
                    $user = auth()->user();
                    $user->balance = $user->balance - $request->amount ;
                    $user->save();
                    
                    $this->sendPush(
                        "মোবাইল রিচার্জ | WIZE TRANSFER",
                        "{$user->name} {$request->amount} টাকা মোবাইল রিচার্জ এর আবেদন করেছেন"
                    );
                    
                    return redirect(route('success',[$data->id,'recharge']));
                 }
    
            }
    
            return view('frontend.recharge') ;

        }


}