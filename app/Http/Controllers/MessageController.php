<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
class MessageController extends Controller
{
    //

    public function sendMessage(Request $request)
    {
        // Logic to send a message
        $validated = $request->validate([
            'sender_id' => 'required|exists:logins,id',
            'receiver_id' => 'required|exists:logins,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => $validated['sender_id'],
            'receiver_id' => $validated['receiver_id'],
            'message' => $validated['message'],
        ]);

        return response()->json(['message' => 'Message sent successfully', 'data' => $message], 201);
    }   

    public function getMessages(Request $request, $userId)
    {
        // Logic to get messages for a user
        $messages = Message::where('receiver_id', $userId)
                            ->orWhere('sender_id', $userId)
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('messages.index', ['messages' => $messages]);
    }
}
