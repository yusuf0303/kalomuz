<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Get unique users current user has chatted with
        $userId = Auth::id();
        $chats = \App\Models\Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($msg) use ($userId) {
                $otherUser = $msg->sender_id == $userId ? $msg->receiver : $msg->sender;
                if ($otherUser) {
                    $otherUser->unread_count = \App\Models\Message::where('sender_id', $otherUser->id)
                        ->where('receiver_id', $userId)
                        ->where('is_read', false)
                        ->count();
                }
                return $otherUser;
            })
            ->filter()
            ->unique('id');

        return view('messages.index', compact('chats'));
    }

    public function search(Request $request)
    {
        $username = $request->input('username');
        $user = \App\Models\User::where('username', $username)->first();

        if ($user) {
            return redirect()->route('messages.chat', $user->id);
        }

        return redirect()->back()->with('error', 'Foydalanuvchi topilmadi.');
    }

    public function chat($userId)
    {
        $targetUser = \App\Models\User::findOrFail($userId);
        $myId = Auth::id();

        $messages = \App\Models\Message::where(function($q) use ($myId, $userId) {
                $q->where('sender_id', $myId)->where('receiver_id', $userId);
            })
            ->orWhere(function($q) use ($myId, $userId) {
                $q->where('sender_id', $userId)->where('receiver_id', $myId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark as read
        \App\Models\Message::where('sender_id', $userId)
            ->where('receiver_id', $myId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('messages.chat', compact('targetUser', 'messages'));
    }

    public function liveSearch(Request $request)
    {
        $query = $request->input('query');
        if (strlen($query) < 2) return response()->json([]);

        $users = \App\Models\User::where('username', 'like', "%{$query}%")
            ->orWhere('name', 'like', "%{$query}%")
            ->where('id', '!=', Auth::id())
            ->limit(10)
            ->get(['id', 'name', 'username']);

        return response()->json($users);
    }

    public function getNewMessages($userId)
    {
        $myId = Auth::id();
        $messages = \App\Models\Message::where('sender_id', $userId)
            ->where('receiver_id', $myId)
            ->where('is_read', false)
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark as read
        if ($messages->count() > 0) {
            \App\Models\Message::where('sender_id', $userId)
                ->where('receiver_id', $myId)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|max:10240' // Max 10MB
        ]);

        $data = [
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message ?? ''
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('attachments', 'public');
            $data['attachment_path'] = $path;
            $data['attachment_type'] = $file->getClientOriginalExtension();
        }

        \App\Models\Message::create($data);

        return redirect()->back();
    }
}
