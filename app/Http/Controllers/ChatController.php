<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Group;
use App\Models\NewMessage;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'nullable|integer|exists:users,id',
            'group_id' => 'nullable|integer|exists:groups,id',
            'type' => 'required|in:text,file,image,voice,sticker,emoji',
            'message' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
        ]);

        $path = null;
        $type = $request->type;

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $path = imageUpload($file);

            $extension = strtolower($file->getClientOriginalExtension());

            if (in_array($extension, ['jpg','jpeg','png','gif','webp'])) {
                $type = 'image';
            } elseif (in_array($extension, ['mp3','wav','ogg','m4a'])) {
                $type = 'voice';
            } else {
                $type = 'file';
            }
        }

        $status = $request->group_id ? 'pending' : 'approved';

        $msg = NewMessage::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'group_id'    => $request->group_id,
            'type'        => $type,
            'message'     => $request->message,
            'file_path'   => $path,
            'status'      => $status
        ]);

        return response()->json($msg);
    }

    public function createGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'users' => 'required|array'
        ]);

        $group = \App\Models\Group::create([
            'name' => $request->name,
            'created_by' => auth()->id()
        ]);

        $group->users()->attach($request->users);

        $group->users()->attach(auth()->id());

        return response()->json([
            'status' => true,
            'group' => $group
        ]);
    }

    public function chatUsers()
    {
        $userId = auth()->id();

        // Get all user IDs that you've sent or received messages with
        $userIds = \App\Models\NewMessage::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->get()
            ->map(function($msg) use($userId) {
                // return the other user ID
                return $msg->sender_id == $userId ? $msg->receiver_id : $msg->sender_id;
            })
            ->unique()
            ->values()
            ->filter(); // remove nulls just in case

        $users = \App\Models\User::whereIn('id', $userIds)->get();

        // active users for stories
    $activeUsers = User::where('id', '!=', auth()->id())
        ->where('status', 1)
        ->get();

    // recent chats
    $recentChats = NewMessage::with('sender', 'receiver')
        ->where('sender_id', auth()->id())
        ->orWhere('receiver_id', auth()->id())
        ->latest('created_at')
        ->get()
        ->groupBy(function($msg) {
            return $msg->sender_id == auth()->id() ? $msg->receiver_id : $msg->sender_id;
        })
        ->map(function($msgs) {
            $last = $msgs->last();
            return (object)[
                'otherUser' => $last->sender_id == auth()->id() ? $last->receiver : $last->sender,
                'last_message_preview' => $last->type == 'text' ? $last->message : ucfirst($last->type),
                'last_message_time' => $last->created_at
            ];
        });

        $groups = $this->chatGroups();

        return view('frontend.chat', compact('users', 'activeUsers', 'recentChats', 'groups'));
    }

    public function fetchMessages(Request $request)
    {
        $request->validate([
            'receiver_id' => 'nullable|integer|exists:users,id',
            'group_id' => 'nullable|integer|exists:groups,id',
            'last_id' => 'nullable|integer'
        ]);

        $query = NewMessage::query();

        // Private chat
        if ($request->receiver_id) {
            $query->where(function ($q) use ($request) {
                $q->where('sender_id', auth()->id())
                ->where('receiver_id', $request->receiver_id);
            })->orWhere(function ($q) use ($request) {
                $q->where('sender_id', $request->receiver_id)
                ->where('receiver_id', auth()->id());
            });
        }

        // Group chat
        if ($request->group_id) {
            $query->where('group_id', $request->group_id);
        }

        // ✅ IMPORTANT: Only get NEW messages
        if ($request->last_id) {
            $query->where('id', '>', $request->last_id);
        }

        $messages = $query->orderBy('id')->get();

        return response()->json($messages);
    }

    public function chatGroups()
    {
        $userId = auth()->id();

        $groups = Group::with(['users', 'messages' => function($q) {
            $q->latest()->limit(1);
        }])
        ->whereHas('users', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->get()
        ->map(function($group) {
            $lastMessage = $group->messages->first();
            return (object)[
                'id' => $group->id,
                'name' => $group->name,
                'last_message_preview' => $lastMessage ? ($lastMessage->type == 'text' ? $lastMessage->message : ucfirst($lastMessage->type)) : '',
                'last_message_time' => $lastMessage ? $lastMessage->created_at : now(),
            ];
        });

        return $groups;
    }
}