<?php

namespace App\Http\Controllers;
use App\Models\MenualPayment;
use Illuminate\Http\Request;

class MenualPaymentController extends Controller
{
    public function index()
    {
        $title = "Manual Payment Methods";

        $paymentData = MenualPayment::all();

        return view('backend.menual-payment.payment_admin', compact('title', 'paymentData'));
    }

    public function getPaymentData(Request $request)
    {
        $selectedGateway = $request->input('gateway');

        $selectedPayment = MenualPayment::where('gateway', $selectedGateway)->first();

        return response()->json($selectedPayment);
    }

   public function store(Request $request)
    {
        $validated = $request->validate([
            'bank' => 'nullable|string',
            'routing_number' => 'nullable|string',
            'account_number' => 'nullable|string',
            'mobile_banking' => 'nullable|string',
            'phone_number' => 'nullable|string',
        ]);

        $gateway = $request->input('mobile_banking') ? $request->input('mobile_banking') : $request->input('bank');

        $data = [
            'gateway' => $gateway,
            'number' => $request->input('phone_number'),
            'routing_number' => $request->input('routing_number'),
            'account_number' => $request->input('account_number'),
        ];

        MenualPayment::updateOrCreate(
            ['gateway' => $gateway], // Check if the gateway already exists
            $data // If it exists, update the data; if not, create new record
        );

        // Redirect back with a success message
        return redirect()->route('menual-payment.index')->with('success', 'Payment Method Added/Updated Successfully!');
    }


}
