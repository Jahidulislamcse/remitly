<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // Show Create User Form
    public function create()
    {
        $modules = ['home', 'deposit', 'recharge', 'withdraw', 'billpay'];
        $roles = ['admin', 'moderator', 'user']; // define roles
        return view('backend.users.create', compact('modules', 'roles'));
    }

    // Handle Form Submission
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:admin,moderator,user',
            'modules' => 'nullable|array',
            'modules.*' => 'string|in:home,deposit,recharge,withdraw,billpay',
            'pin' => 'required|integer|digits:4',
            'password' => 'nullable|string|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->location = $request->location;
        $user->role = $request->role;
        $user->modules = $request->modules ? json_encode($request->modules) : null;
        $user->pin = $request->pin;
        $user->password = $request->password ? bcrypt($request->password) : bcrypt(Str::random(8));
        $user->status = 1; 
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads/users'), $imageName);
            $user->image = 'uploads/users/' . $imageName;
        }
        $user->save();

        return redirect()->route('user.list')->with('msg', 'User created successfully');
    }
}