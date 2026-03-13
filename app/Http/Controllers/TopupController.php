<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Commition;
use App\Models\Country;
use App\Models\Topup;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Notifications\PushNotification;
use App\Traits\SendPushNotification;


class TopupController extends Controller
{
    use SendPushNotification;


    public function topup_list(Request $request)
    {
        $lists = Topup::orderBy('created_at', 'desc')->paginate(50); 
        return view('backend.topup_list', compact('lists'));
    }
    
    public function topup_approve($id)
    {


        $data = Topup::find($id);
        $data->status = 1;
        if ($data->save()) {
            $user = User::find($data->user_id);
            $user->balance = $user->balance + $data->amount + $data->commision;
            $user->commision = $user->commision + $data->commision;
            $user->save();
            return back()->with(['response' => true, 'msg' => 'Topup Approved!']);
        }

        return back()->with(['response' => false, 'msg' => 'Topup Not Approved!']);
    }
    public function topup_reject($id)
    {


        $data = Topup::find($id);
        $data->status = 2;
        if ($data->save()) {

            return back()->with(['response' => true, 'msg' => 'Topup Rejected!']);
        }

        return back()->with(['response' => false, 'msg' => 'Topup Not Rejected!']);
    }
    public function topup_delete($id)
    {


        $data = Topup::find($id);
        if ($data->delete()) {
            return redirect(back())->with(['response' => true, 'msg' => 'Topup Deleted!']);
        }

        return redirect(back())->with(['response' => false, 'msg' => 'Topup Not Deleted!']);
    }



    public function bank_topup(Request $request)
    {
        // dd(($request->all()));
        if ($request->post()) {
            $request->validate([
                'type'       => ['required', 'string'],
                'amount'     => ['required', 'numeric', 'min:0'],
                'account_id' => ['required', 'integer', 'exists:accounts,id'],
                'account'    => ['nullable', 'string'],
                'file'       => ['nullable', 'file', 'max:2048'],
            ]);

            $transaction_id =  strtoupper(Str::random(7));
            $commision = Commition::where('type', $request->type)->first();

            if ($commision) {
                $commision_amount = ($commision->percentage / 100) * $request->amount;
            } else {
                $commision_amount = 0;
            }

            $data = new Topup();
            $data->transaction_id = $transaction_id;
            $data->type = $request->type;

            if ($request->hasFile('file')) {
                $data->file = imageUpload($request->file);
            }
            $data->amount = $request->amount;
            $data->commision = $commision_amount;
            $data->gateway_id = $request->account_id;
            $data->account = $request->account;
            $data->status = 0;
            $data->user_id = auth()->user()->id;
            
            if ($data->save()) {
                 $user = auth()->user();
                
                 $this->sendPush(
                    "ডিপোজিট | WIZE TRANSFER",
                    "{$user->name} {$data->gateway->name} এর মাধ্যমে {$request->amount} টাকা ডিপোজিট করেছেন"
                );
                
                return redirect(route('success', [$data->id, 'topup']));
            }
        }

        $user = auth()->user();
        $lists = Topup::with('gateway')
            ->where('user_id', $user->id)
            ->where(function ($q) {
                $q->whereNotNull('file')
                    ->orWhereNull('mobile');
            })
            ->orderBy('id', 'desc')
            ->get();
        $rate = null;
        $country = null;
        $accounts = Account::where('type', 'Bank')->get();


        if ($user->location) {
            $country = Country::find($user->location);

            if ($country) {
                $rate = $country->rate;
            }
        }

        return view('frontend.bank_topup', compact('accounts', 'country', 'rate', 'lists'));
    }


    public function topup(Request $request)
    {
        // dd(($request->all()));

        if ($request->post()) {

            $request->validate([
                'type'       => ['required', 'string'],
                'amount'     => ['required', 'numeric', 'min:0'],
                'account_id' => ['required', 'integer', 'exists:accounts,id'],
                'acc'        => ['required', 'string'],
                'file'       => ['nullable', 'file', 'max:2048'],
            ]);

            $transaction_id =  strtoupper(Str::random(7));
            $commision = Commition::where('type', $request->type)->first();

            if ($commision) {
                $commision_amount = ($commision->percentage / 100) * $request->amount;
            } else {
                $commision_amount = 0;
            }

            $data = new Topup();
            $data->transaction_id = $transaction_id;
            $data->type = $request->type;
            $data->amount = $request->amount;
            $data->commision = $commision_amount;
            $data->account = $request->account;
            $data->status = 0;
            $data->gateway_id = $request->account_id;
            $data->mobile = $request->acc;
            $data->user_id = auth()->user()->id;

            if ($request->hasFile('file')) {
                $data->file = imageUpload($request->file);
            }

            if ($data->save()) {
                 $user = auth()->user();
                
                 $this->sendPush(
                    "ডিপোজিট | WIZE TRANSFER",
                    "{$user->name} {$data->gateway->name} এর মাধ্যমে {$request->amount} টাকা ডিপোজিট করেছেন"
                );
                
                return redirect(route('success', [$data->id, 'topup']));
            }
        }

        $accounts = Account::where('type', 'Mobile Banking')->get();
        $user = auth()->user();
        $lists = Topup::with('gateway')
            ->where('user_id', $user->id)
            ->where(function ($q) {
                $q->whereNotNull('mobile');
            })
            ->orderBy('id', 'desc')
            ->get();
        $rate = null;
        $country = null;

        if ($user->location) {
            $country = Country::find($user->location);

            if ($country) {
                $rate = $country->rate;
            }
        }

        return view('frontend.topup', compact('country', 'rate', 'accounts', 'lists'));
    }
}