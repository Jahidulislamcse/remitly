<?php

namespace App\Http\Controllers;

use App\Models\PayableAccount;
use Illuminate\Http\Request;

class PayableAccountController extends Controller
{
    public function index()
    {
        $accounts = PayableAccount::all();
        return view('backend.setting.payable_accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('backend.setting.payable_accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type' => 'required|in:mobile_banking,bank_account',
        ]);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();

            $logo->move(public_path('logos'), $logoName);
            $logoPath = 'logos/' . $logoName;
        }

        PayableAccount::create([
            'name' => $request->name,
            'logo' => $logoPath,
            'type' => $request->type,
        ]);

        return redirect()->route('admin.payable_accounts.index')->with('success', 'Payable Account Created Successfully');
    }


    // Show the form to edit a payable account
    public function edit($id)
    {
        $account = PayableAccount::findOrFail($id);
        return view('backend.setting.payable_accounts.edit', compact('account'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type' => 'required|string|max:255',
        ]);

        $account = PayableAccount::findOrFail($id);

        if ($request->hasFile('logo')) {
            if ($account->logo && file_exists(public_path($account->logo))) {
                unlink(public_path($account->logo));
            }

            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();

            $logo->move(public_path('logos'), $logoName);
            $account->logo = 'logos/' . $logoName;
        }

        $account->name = $request->name;
        $account->type = $request->type;
        $account->save();

        return redirect()->route('admin.payable_accounts.index')->with('success', 'Payable Account Updated Successfully');
    }

    public function destroy($id)
    {
        $account = PayableAccount::findOrFail($id);

        if ($account->logo && file_exists(public_path($account->logo))) {
            unlink(public_path($account->logo));
        }

        $account->delete();

        return redirect()->route('admin.payable_accounts.index')->with('success', 'Payable Account Deleted Successfully');
    }


}
