<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    //

    public function alert(){
        return view('backend.alert');
    }
    public function index()
    {
       
        $list = Notification::orderBy('created_at', 'desc')->get();

        return view('backend.notification', compact('list'));
    }
    public function create()
    {
        return view('backend.notification');
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        Notification::create([
            'message' => $request->message,
        ]);

        return redirect()->route('notifications.index')->with('success', 'Notification created successfully.');
    }

    public function edit(Notification $notification)
    {
        $list = Notification::orderBy('created_at', 'desc')->get();
        return view('backend.notification', compact('notification', 'list'));
    }

    public function update(Request $request, Notification $notification)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $notification->update([
            'message' => $request->message,
        ]);

        return redirect()->route('notifications.index')->with('success', 'Notification updated successfully.');
    }

    public function delete($id)
    {
        Notification::find($id)->delete();

        return redirect()->route('notifications.index')->with('success', 'Notification deleted successfully.');
    }
    public function getNotification()
    {
        $user = Auth::user();

        $notification = Notification::whereDoesntHave('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->orderBy('created_at', 'asc')->first();

        if ($notification) {
            // Mark as seen
            $user->notifications()->attach($notification->id, [
                'seen' => true,
                'seen_at' => now()
            ]);

            return response()->json(['message' => $notification->message]);
        }

        return response()->json(['message' => null]);
    }
    public function getRandomNotification()
    {
       
        $notification = Notification::inRandomOrder()->first();

        if ($notification) {
           
            return response()->json(['message' => $notification->message]);
        }

        return response()->json(['message' => null]);
    }
}
