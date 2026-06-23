<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Notification $notification)
    {
        $this->authorize('update', $notification);
        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notification marquée comme lue.');
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return redirect()->back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    public function unreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    public static function create(array $data)
    {
        return Notification::create([
            'type' => $data['type'],
            'title' => $data['title'],
            'message' => $data['message'],
            'user_id' => Auth::id(),
        ]);
    }
}
