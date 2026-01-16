<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * MessageController - Handles all messaging functionality
 * 
 * This controller manages:
 * - Sending messages between users
 * - Retrieving conversation history
 * - Message validation and storage
 */
class MessageController extends Controller
{
    /**
     * sendMessage - Handles sending a new message
     * 
     * Process:
     * 1. Validates the incoming request data
     * 2. Creates and stores the new message
     * 3. Retrieves the updated conversation
     * 4. Returns the chat view with all messages
     * 
     * @param Request $request - Contains sender_id, receiver_id, and message
     * @return \Illuminate\View\View - Returns chat view with updated messages
     */
    public function sendMessage(Request $request)
    {
        // Step 1: Validate the incoming request data
        // - sender_id: must exist in logins table
        // - receiver_id: must exist in logins table  
        // - message: required string content
        $validated = $request->validate([
            'sender_id' => 'required|exists:logins,id',
            'receiver_id' => 'required|exists:logins,id',
            'message' => 'required|string',
        ]);

        // Step 2: Create and store the new message in database
        Message::create([
            'sender_id' => $validated['sender_id'],
            'receiver_id' => $validated['receiver_id'],
            'message' => $validated['message'],
        ]);

        // Step 3: Get conversation between current user and selected user
        // This retrieves ALL messages between these two users
        $currentUserId = $validated['sender_id'];
        $selectedUserId = $validated['receiver_id'];
        
        // Complex query to get conversation between two specific users
        // Uses nested WHERE clauses to ensure we only get messages
        // between these exact two users, regardless of who sent/received
        $messages = Message::where(function($query) use ($currentUserId, $selectedUserId) {
                            // Messages where current user is sender AND selected user is receiver
                            $query->where('sender_id', $currentUserId)
                                  ->where('receiver_id', $selectedUserId);
                        })
                        ->orWhere(function($query) use ($currentUserId, $selectedUserId) {
                            // OR messages where selected user is sender AND current user is receiver
                            $query->where('sender_id', $selectedUserId)
                                  ->where('receiver_id', $currentUserId);
                        })
                        ->orderBy('created_at', 'asc') // Order by time (oldest first)
                        ->get();
                        
        // Step 4: Get all users except current user for sidebar
        $users = Login::all()->except(Auth::guard('login')->id());
        
        // Step 5: Return chat view with all necessary data
        return view('chat', [
            'messages' => $messages,           // Conversation messages
            'users' => $users,               // All other users
            'user_id' => $selectedUserId       // Currently selected user
        ]);
    }   

    /**
     * getMessages - Retrieves conversation history for a specific user
     * 
     * Process:
     * 1. Gets current authenticated user ID
     * 2. Retrieves conversation between current user and specified user
     * 3. Returns chat view with conversation data
     * 
     * @param Request $request - HTTP request object
     * @param int $userId - ID of the user to get conversation with
     * @return \Illuminate\View\View - Returns chat view with messages
     */
    public function getMessages(Request $request, $userId)
    {
        // Step 1: Get currently authenticated user's ID
        // Uses 'login' guard because we're using Login model for authentication
        $currentUserId = Auth::guard('login')->id();
        
        // Step 2: Retrieve conversation between current user and specified user
        // Same complex query logic as in sendMessage method
        $messages = Message::where(function($query) use ($currentUserId, $userId) {
                            // Current user sent to specified user
                            $query->where('sender_id', $currentUserId)
                                  ->where('receiver_id', $userId);
                        })
                        ->orWhere(function($query) use ($currentUserId, $userId) {
                            // Specified user sent to current user
                            $query->where('sender_id', $userId)
                                  ->where('receiver_id', $currentUserId);
                        })
                        ->orderBy('created_at', 'asc') // Chronological order
                        ->get();

        // Step 3: Get all users except current user for sidebar
        $users = Login::all()->except($currentUserId);
        
        // Step 4: Return chat view with conversation data
        return view('chat', [
            'messages' => $messages,     // Conversation messages
            'users' => $users,           // All other users  
            'user_id' => $userId         // Selected user ID
        ]);
    }
}
