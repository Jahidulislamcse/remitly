<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Group;
use App\Models\User;

class GroupController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'users' => 'required|array'
        ]);

        $group = Group::create([
            'name' => $request->name,
            'created_by' => auth()->id()
        ]);

        // attach members
        $group->users()->attach($request->users);

        // add creator automatically
        $group->users()->attach(auth()->id());

        return response()->json($group);
    }

}