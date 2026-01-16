<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

/**
 * LoginController - Handles user authentication and session management
 * 
 * This controller manages:
 * - User registration (signup)
 * - User authentication (login)
 * - User logout and session cleanup
 * - Chat interface navigation
 * - User session management
 */
class LoginController extends Controller
{
    /**
     * login - Authenticates user and creates session
     * 
     * Process:
     * 1. Validates email and password
     * 2. Attempts authentication using 'login' guard
     * 3. Regenerates session for security
     * 4. Redirects to chat view on success
     * 5. Returns error on failed login
     * 
     * @param Request $request - Contains email and password
     * @return \Illuminate\Http\RedirectResponse - Redirects on success/failure
     */
    public function login(Request $request)
    {
        // Step 1: Validate the login credentials
        // - email: must be valid email format
        // - password: required string
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Step 2: Attempt authentication using 'login' guard
        // 'login' guard corresponds to our Login model authentication
        if(Auth::guard('login')->attempt($validated)) {
            // Step 3: Regenerate session ID for security
            // Prevents session fixation attacks
            $request->session()->regenerate();
            
            // Step 4: Redirect to chat view on successful login
            return redirect()->route('chatView');
        }
        
        // Step 5: Return to login page with error message
        // OnlyInput('email') preserves the email input for user convenience
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * signup - Registers new user account
     * 
     * Process:
     * 1. Validates user registration data
     * 2. Hashes password for security
     * 3. Creates new user in database
     * 4. Automatically logs in new user
     * 5. Redirects to chat view
     * 
     * @param Request $request - Contains name, email, password, password_confirmation
     * @return \Illuminate\Http\RedirectResponse - Redirects to chat view
     */
    public function signup(Request $request)
    {
        // Step 1: Validate registration data
        // - name: required string, max 255 chars
        // - email: required email, unique in logins table
        // - password: required, min 4 chars, must match confirmation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:logins,email',
            'password' => 'required|string|min:4|confirmed',
        ]);

        // Step 2: Create new user with hashed password
        // Hash::make() securely encrypts the password
        $user = Login::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Step 3: Automatically log in the new user
        // This saves user from having to login again after registration
        Auth::guard('login')->login($user);
        
        // Step 4: Redirect to chat view
        return redirect()->route('chatView');
    }

    /**
     * chatView - Displays main chat interface with user list
     * 
     * Process:
     * 1. Gets all users except current user
     * 2. Returns chatView with user list for sidebar
     * 
     * @return \Illuminate\View\View - Returns chatView with users list
     */
    public function chatView()
    {
        // Step 1: Get all users except currently authenticated user
        // except() removes current user from the collection
        // This is for the sidebar - we don't want to chat with ourselves
        $users = Login::all()->except(Auth::guard('login')->id());
        
        // Step 2: Return chatView with users list
        return view('chatView', ['users' => $users]);
    }

    /**
     * chat - Displays chat interface with specific user
     * 
     * Process:
     * 1. Gets current user ID from authentication
     * 2. Retrieves conversation between current user and selected user
     * 3. Gets all users for sidebar
     * 4. Returns chat view with conversation data
     * 
     * @param int $user_id - ID of user to chat with
     * @return \Illuminate\View\View - Returns chat view with messages and users
     */
    public function chat($user_id)
    {
        // Step 1: Get currently authenticated user's ID
        $currentUserId = Auth::guard('login')->id();
        
        // Step 2: Get conversation between current user and selected user
        // Uses same complex query as MessageController for consistency
        $messages = Message::where(function($query) use ($currentUserId, $user_id) {
                            // Messages where current user sent to selected user
                            $query->where('sender_id', $currentUserId)
                                  ->where('receiver_id', $user_id);
                        })
                        ->orWhere(function($query) use ($currentUserId, $user_id) {
                            // Messages where selected user sent to current user
                            $query->where('sender_id', $user_id)
                                  ->where('receiver_id', $currentUserId);
                        })
                        ->orderBy('created_at', 'asc') // Chronological order
                        ->get();
                        
        // Step 3: Get all users except current user for sidebar
        $users = Login::all()->except($currentUserId);
        
        // Step 4: Return chat view with all necessary data
        return view('chat', [
            'users' => $users,           // All other users for sidebar
            'user_id' => $user_id,       // Selected user ID
            'messages' => $messages        // Conversation messages
        ]);
    }

    /**
     * logout - Logs out user and cleans up session
     * 
     * Process:
     * 1. Logs out user from 'login' guard
     * 2. Invalidates the session completely
     * 3. Regenerates CSRF token for security
     * 4. Redirects to login page
     * 
     * @param Request $request - HTTP request for session management
     * @return \Illuminate\Http\RedirectResponse - Redirects to login page
     */
    public function logout(Request $request)
    {
        // Step 1: Log out user from authentication system
        Auth::guard('login')->logout();
        
        // Step 2: Invalidate the entire session
        // This removes all session data
        $request->session()->invalidate();
        
        // Step 3: Regenerate CSRF token
        // Prevents CSRF attacks after logout
        $request->session()->regenerateToken();
        
        // Step 4: Redirect to login page
        return redirect()->route('login');
    }
}
