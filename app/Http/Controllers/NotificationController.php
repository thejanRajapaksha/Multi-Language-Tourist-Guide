<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // In NotificationController.php
    public function markAsRead(Request $request)
    {
        // Assuming you have a Notification model and the user is authenticated
        Notification::where('user_id', Auth::id())->update(['read' => true]);

        return response()->json(['success' => true]);
    }
}
