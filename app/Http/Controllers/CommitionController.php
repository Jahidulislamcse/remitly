<?php

namespace App\Http\Controllers;

use App\Models\Commition;
use Illuminate\Http\Request;
use App\Http\Requests\CommitionRequest;

class CommitionController extends Controller
{
    public function index()
    {
        $title = 'Commition List';
        $commitions = Commition::latest()->get();
        return view('backend.setting.commission.index', compact('title', 'commitions'));
    }

    public function create()
    {
        $title = 'Create Commition';
        $commition = new Commition();
        return view('backend.setting.commission.create', compact('title', 'commition'));
    }

    public function store(CommitionRequest $request)
    {
        Commition::create($request->validated());
        return redirect()->route('admin.commission.index')
            ->with('success', 'Commition created successfully.');
    }

    public function edit($id)
    {
        $title = 'Edit Commition';
        $commition = Commition::findOrFail($id);
        return view('backend.setting.commission.edit', compact('title', 'commition'));
    }

    public function update(CommitionRequest $request, $id)
    {
        $commition = Commition::findOrFail($id);

        $commition->update($request->validated());

        return redirect()->route('admin.commission.index')
            ->with('success', 'Commition updated successfully.');
    }


    public function destroy($id)
    {
        $commition = Commition::findOrFail($id);
        $commition->delete();
        return redirect()->route('admin.commission.index')
            ->with('success', 'Commition deleted successfully.');
    }
}
