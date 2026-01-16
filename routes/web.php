<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MessageController;

/**
 * Web Routes - Application URL routing configuration
 * 
 * This file defines all HTTP routes for the chat application:
 * - Public routes (login, signup pages)
 * - Authentication routes (login, signup, logout)
 * - Protected routes (chat functionality)
 * - API routes (message handling)
 */

// ============================================================================
// PUBLIC ROUTES - No authentication required
// ============================================================================

/**
 * Home Route - Root URL redirect
 * 
 * Redirects visitors to login page
 * Ensures all users start at authentication
 */
Route::get('/', function () {
    return view('login');
});

/**
 * Login Page Route - Display login form
 * 
 * Returns the login view for users to sign in
 * Named 'login' for easy reference in redirects
 */
Route::get('/login', function () {
    return view('login');
})->name('login');

/**
 * Signup Page Route - Display registration form
 * 
 * Returns the signup view for new user registration
 * Named 'signup' for easy reference in links
 */
Route::get('/signup', function () {
    return view('signup');
})->name('signup');

// ============================================================================
// AUTHENTICATION ROUTES - Handle user authentication
// ============================================================================

/**
 * Login POST Route - Process login form
 * 
 * Handles login form submission
 * Validates credentials and creates session
 * Uses LoginController@login method
 */
Route::post('/login', [LoginController::class, 'login'])->name('login');

/**
 * Signup POST Route - Process registration form
 * 
 * Handles user registration form submission
 * Validates data, creates user, logs them in
 * Uses LoginController@signup method
 */
Route::post('/signup', [LoginController::class, 'signup'])->name('signup');

// ============================================================================
// PROTECTED ROUTES - Authentication required
// ============================================================================

/**
 * Authenticated Route Group - Requires user login
 * 
 * All routes in this group require:
 * - auth:login middleware (user must be authenticated)
 * - prevent-back-history middleware (prevents back button after logout)
 * 
 * This protects chat functionality from unauthorized access
 */
Route::middleware(['auth:login','prevent-back-history'])->group(function () {
    
    /**
     * Logout Route - End user session
     * 
     * Handles user logout request
     * Clears session and redirects to login
     * Uses LoginController@logout method
     */
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    /**
     * Chat View Route - Main chat interface
     * 
     * Displays the main chat view with user list
     * Shows all available users for chat
     * Uses LoginController@chatView method
     */
    Route::get('/chatView', [LoginController::class, 'chatView'])->name('chatView');
    
    /**
     * Chat Route - Specific user chat
     * 
     * Displays chat interface with a specific user
     * Shows conversation history between users
     * URL parameter: user_id (the user to chat with)
     * Uses LoginController@chat method
     */
    Route::get('/chat/{user_id}', [LoginController::class, 'chat'])->name('chat');
    
    /**
     * Get Messages Route - API endpoint for conversation history
     * 
     * Retrieves conversation messages between users
     * Useful for AJAX calls or direct API access
     * URL parameter: user_id (the user to get messages with)
     * Uses MessageController@getMessages method
     */
    Route::get('/messages/{user_id}', [MessageController::class, 'getMessages'])->name('getMessages');
    
    /**
     * Send Message Route - API endpoint for sending messages
     * 
     * Handles message submission from chat interface
     * Validates and stores new messages
     * Returns updated chat view with new message
     * Uses MessageController@sendMessage method
     */
    Route::post('/send-message', [MessageController::class, 'sendMessage'])->name('sendMessage'); 
});

// ============================================================================
// ROUTE SUMMARY
// ============================================================================
// 
// Public Routes:
// - GET  /           -> login view
// - GET  /login     -> login view  
// - GET  /signup    -> signup view
// 
// Auth Routes:
// - POST /login     -> process login
// - POST /signup    -> process signup
// 
// Protected Routes (require authentication):
// - POST /logout           -> logout user
// - GET  /chatView         -> main chat interface
// - GET  /chat/{user_id}    -> chat with specific user
// - GET  /messages/{user_id} -> get conversation API
// - POST /send-message       -> send message API
// 
// Middleware:
// - auth:login - ensures user is authenticated
// - prevent-back-history - prevents browser back after logout

