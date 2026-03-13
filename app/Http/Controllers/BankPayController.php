<?php

namespace App\Http\Controllers;

use App\Models\BankPay;
use App\Models\PayableAccount;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Notifications\PushNotification;
use App\Traits\SendPushNotification;

class BankPayController extends Controller
{
    use SendPushNotification;

    public function list()
    {
        $lists = BankPay::orderBy('id', 'desc')->get();
        return view('backend.bank_pay_list', compact('lists'));
    }
    public function approve($id)
    {
        $recharge = BankPay::findOrFail($id);
        $recharge->status = 1;
        $recharge->save();

        return redirect()->back()->with(['response' => true, 'msg' => 'Bank Pay Approved!']);
    }
    public function reject($id)
    {
        $recharge = BankPay::findOrFail($id);
        $recharge->status = 2;
        $recharge->save();

        $user = $recharge->user;
        $user->balance += $recharge->amount;
        $user->save();

        return redirect()->back()->with(['response' => true, 'msg' => 'Bank Pay Rejected and Amount Refunded!']);
    }

    public function delete($id)
    {
        $transaction = BankPay::findOrFail($id);
        if( $transaction->delete()){
            return redirect()->back()->with(['response' => true, 'msg' => ' Bank Pay Deleted!']);
        }
    }


    public function bankpay(Request $request){
        // dd($request->all());
        if ($request->post()) {
            

            $request->validate([
                'operator' => 'required',
                'amount' => 'required|numeric|min:1',
                'mobile' => 'required|numeric|min:10',
                'branch' => 'required',
                'achold' => 'required'
            ]);

             if( $request->pin != auth()->user()->pin){
                return redirect()->back()->with(['response' => false, 'msg' => 'Invalid Pin code!']);
            }

            if( $request->amount > auth()->user()->balance){
                return redirect()->back()->with(['response' => false, 'msg' => 'Please Topup First!']);
            }

            $transaction_id =  strtoupper(Str::random(7));
            $data = new BankPay() ;
            $data->transaction_id = $transaction_id ;
            $data->operator = $request->operator ;

            $data->amount = $request->amount ;
            $data->mobile = $request->mobile ;
            $data->branch = $request->branch ;
            $data->achold = $request->achold ;

            $data->user_id = auth()->user()->id;
            $data->status = 0 ;

            if ($data->save()) {
                $user = auth()->user();
                $user->balance = $user->balance - $request->amount ;
                $user->save();

            $this->sendPush(
                "ব্যাংক উত্তোলন | WIZE TRANSFER",
                "{$user->name} ব্যাংকের মাধ্যমে {$request->amount} টাকা উত্তোলনের আবেদন করেছেন"
            );

                    return redirect(route('success',[$data->id,'bankpay']));
             }

        }

        $user = auth()->user();
        $rate = null;
        $country = null;
        $payable_accounts = PayableAccount::where('type', 'bank_account')->get();

        if ($user->location) {
        $country = \App\Models\Country::find($user->location);

        if ($country && $country->currency_code) {
            try {
                // Use your API key
                $apiKey = '55dfd34b7d585b2674304254';
                $response = Http::get("https://v6.exchangerate-api.com/v6/{$apiKey}/latest/{$country->currency_code}");

                if ($response->successful() && isset($response['conversion_rates']['BDT'])) {
                    $rate = $response['conversion_rates']['BDT'];
                } else {
                    \Log::error('Rate API failed: ', $response->json());
                }
            } catch (\Exception $e) {
                \Log::error('Rate fetch exception: ' . $e->getMessage());
            }
        }
        }

        return view('frontend.bank-pay', compact('country', 'rate', 'payable_accounts')); ;

    }
}