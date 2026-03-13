<?php


namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    public function index()
    {
        $guide = Guide::first();

        if (!$guide) {
            return redirect()->route('guides.create')->with('error', 'No guide available.');
        }

        return view('guides.index', compact('guide'));
    }

    public function create()
    {
        return view('guides.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mobile_deposit' => 'nullable|string',
            'bank_deposit' => 'nullable|string',
            'customer_care' => 'nullable|string',
            'cash_pickup' => 'nullable|string',
            'loan' => 'nullable|string',
            'remittance' => 'nullable|string',
            'how_to_balance_add' => 'nullable|string',
            'how_to_bank_transfer' => 'nullable|string',
            'how_to_mobile_banking' => 'nullable|string',
            'about_us' => 'nullable|string',
            'mobile_menual_deposit' => 'nullable|string',
        ]);

        Guide::create($request->all());

        return redirect()->route('guides.index')->with('success', 'Guide saved successfully.');
    }

    public function edit(Guide $guide)
    {
        return view('guides.edit', compact('guide'));
    }

    public function update(Request $request, Guide $guide)
    {
        $request->validate([
            'mobile_deposit' => 'nullable|string',
            'bank_deposit' => 'nullable|string',
            'customer_care' => 'nullable|string',
            'cash_pickup' => 'nullable|string',
            'loan' => 'nullable|string',
            'remittance' => 'nullable|string',
            'how_to_balance_add' => 'nullable|string',
            'how_to_bank_transfer' => 'nullable|string',
            'how_to_mobile_banking' => 'nullable|string',
            'about_us' => 'nullable|string',
            'mobile_menual_deposit' => 'nullable|string',
        ]);

        $guide->update($request->all());

        return redirect()->route('guides.index')->with('success', 'Guide updated successfully.');
    }
}
