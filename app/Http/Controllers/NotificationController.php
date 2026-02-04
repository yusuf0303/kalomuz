<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notifications = Auth::user()->notifications()->get();
        return view('notifications.index', compact('notifications'));
    }

    public function markRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->update(['read_at' => now()]);
        return response()->json(['status' => 'ok']);
    }
}
