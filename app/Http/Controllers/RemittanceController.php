<?php

namespace App\Http\Controllers;

use App\Models\Remittance;
use App\Models\PayableAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Notifications\PushNotification;
use App\Traits\SendPushNotification;

class RemittanceController extends Controller
{
    use SendPushNotification;
    
    public function remittance(Request $request)
    {
        if ($request->post()) {
            $request->validate([
                'operator' => 'required',
                'amount'   => [
                    'required',
                    'numeric',
                    'min:1',
                    'min:25000',
                    function ($attribute, $value, $fail) {
                        if ($value > auth()->user()->balance) {
                            $fail('Amount cannot exceed your available balance.');
                        }
                    },
                ],
                'account'  => 'required|numeric|min:10',
                'branch'   => 'nullable|string',
                'achold'   => 'required|string',
                'pin'      => 'required'
            ]);

            if ($request->pin != auth()->user()->pin) {
                return redirect()->back()->with(['response' => false, 'msg' => 'Invalid Pin code!']);
            }

            if ($request->amount > auth()->user()->balance) {
                return redirect()->back()->with(['response' => false, 'msg' => 'Please Topup First!']);
            }

            $transaction_id = strtoupper(Str::random(7));
            $data = new Remittance();
            $data->transaction_id = $transaction_id;
            $data->operator = $request->operator;
            $data->amount   = $request->amount;
            $data->account  = $request->account;
            $data->branch   = $request->branch;
            $data->achold   = $request->achold;
            $data->user_id  = auth()->user()->id;
            $data->status   = 0;

            if ($data->save()) {
                $user = auth()->user();
                $user->balance = $user->balance - $request->amount;
                $user->save();
                
                $this->sendPush(
                    "রেমিটেন্স | WIZE TRANSFER",
                    "{$user->name} {$request->amount} টাকা {$request->operator} এর মাধ্যমে রেমিটেন্স পাঠানোর আবেদন করেছেন"
                );

                return redirect(route('success', [$data->id, 'remittance']));
            }
        }

        $remittances = Remittance::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        $user    = auth()->user();

        $mobile_accounts = PayableAccount::where('type', 'mobile_banking')->get();
        $bank_accounts   = PayableAccount::where('type', 'bank_account')->get();

        return view('frontend.remittance', compact('mobile_accounts', 'bank_accounts', 'remittances', 'user'));
    }

    // Admin list/approve/reject/delete (mirroring your BankPay)
    public function list(Request $request)
    {
        $lists = Remittance::with('user')->latest()->paginate(50);
        $title = 'Remittance Requests';
        return view('backend.remittance.remittance_list', compact('lists', 'title'));
    }

    public function approve($id, Request $request)
    {
        $item = Remittance::findOrFail($id);
        $item->status = 1;
        $item->save();

        return redirect()->back()->with(['response' => true, 'msg' => 'Remittance approved']);
    }

    public function reject($id, Request $request)
    {
        $item = Remittance::findOrFail($id);

        // Optional: refund on reject if still pending
        if ($item->status == 0) {
            $user = $item->user;
            $user->balance += $item->amount;
            $user->save();
        }

        $item->status = 2;
        $item->save();

        return redirect()->back()->with(['response' => true, 'msg' => 'Remittance rejected']);
    }

    public function delete($id, Request $request)
    {
        $item = Remittance::findOrFail($id);
        $item->delete();

        return redirect()->back()->with(['response' => true, 'msg' => 'Remittance deleted']);
    }
}