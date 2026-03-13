<?php

namespace App\Http\Controllers;

use App\Models\CashInCashOut;
use Illuminate\Http\Request;
use App\Models\CashTransaction;
use App\Models\MenualPayment;

class CashInCashOutController extends Controller
{
    public function index()
    {
        $depositRequests = CashInCashOut::where('type', 'cash_in')->get();
        $withdrawRequests = CashInCashOut::where('type', 'cash_out')->get();
        $paymentMethods = MenualPayment::all();
        return view('cashincashout.index', compact('depositRequests', 'withdrawRequests', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:cash_in,withdraw',
            'transaction_number' => 'required|string|max:255|unique:cash_in_cash_out,transaction_number',
            'payment_method' => 'required|exists:menual_payments,id',
        ]);

        $paymentMethod = MenualPayment::findOrFail($request->payment_method);

        $sendingPhoneNumber = null;
        if ($paymentMethod->number && $request->has('sending_phone_number')) {
            $sendingPhoneNumber = $request->sending_phone_number;
        }

        $cashInCashOut = CashInCashOut::create([
            'user_id' => auth()->user()->id,
            'bank_account_id' => $paymentMethod->id,
            'transaction_number' => $request->transaction_number,
            'sending_phone_number' => $sendingPhoneNumber,
            'amount' => $request->amount,
            'type' => $request->type,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Request submitted successfully.');
    }



    public function show($id)
    {
        $data = CashInCashOut::findOrFail($id);

        $gateway = MenualPayment::where('id', $data->bank_account_id)->first();
        $paymentMethod = $gateway->gateway;

        return response()->json([
            'id' => $data->id,
            'transaction_number' => $data->transaction_number,
            'amount' => $data->amount,
            'status' => $data->status,
            'payment_method' =>  $paymentMethod,
            'sending_phone_number' => $data->sending_phone_number,
        ]);
    }

    // This function is to update the status (Approve or Decline)
    public function updateStatus(Request $request, $id)
    {
        // Validate the status input
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        // Find the cash-in/cash-out request by ID
        $transaction = CashInCashOut::findOrFail($id);

        // Update the status
        $transaction->status = $request->status;
        $transaction->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Transaction status updated.');
    }
}
