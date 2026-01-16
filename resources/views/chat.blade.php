{{-- 
    chat.blade.php - Main chat interface view
    
    This view displays:
    - Complete chat interface with selected user
    - Conversation history between users
    - Message input form for sending new messages
    - User sidebar and navigation
    
    Data passed from controller:
    @param Collection $messages - Conversation messages
    @param Collection $users - All users except current user
    @param int $user_id - Selected user ID for chat
--}}

@extends('layout.layout')

{{-- Page Title --}}
@section('title')
    Chat
@endsection

{{-- Main Content Area --}}
@section('content')
   {{-- User Sidebar - Shows all available users for chat --}}
   <x-sidebar :users="$users" />
   
   {{-- Welcome Header - Shows current user info and navigation --}}
   <x-welcome :user="Auth::user()" />
   
   {{-- Chat Component - Main messaging interface --}}
   {{-- 
       Props passed to chat component:
       - id: $user_id (selected user to chat with)
       - user: Auth::user() (currently authenticated user)
       - messages: $messages (conversation history)
   --}}
   <x-chat :id="$user_id" :user="Auth::user()" :messages="$messages" />
@endsection