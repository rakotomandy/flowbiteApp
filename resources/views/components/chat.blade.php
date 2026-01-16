{{-- 
    chat.blade.php - Chat interface component
    
    This component handles:
    - Displaying conversation messages
    - Differentiating sent/received messages
    - Message input form
    - Real-time chat interface
    
    Props received:
    @param int $id - Selected user ID to chat with
    @param User $user - Currently authenticated user
    @param Collection $messages - Conversation history
--}}
@props(['id','user','messages'])

{{-- Main chat container - Takes up 80% of screen width --}}
<div class="absolute top-19 left-6 w-[80%] ml-[18.3%] h-[90vh] flex flex-col items-center justify-center gap-6 bg-gray-100">

    {{-- Chat Area - Contains header, messages, and input form --}}
    <div class="flex flex-col flex-1 w-full">

        {{-- Chat Header - Shows selected user info --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-white dark:bg-gray-800">
            <div class="flex items-center gap-3">
                {{-- User Avatar - Placeholder image for now --}}
                <img class="w-10 h-10 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user">
                <div>
                    {{-- User Name - Display name of person we're chatting with --}}
                    <h2 class="font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h2>
                    {{-- Online Status - Static "Online" indicator --}}
                    <span class="text-sm text-green-500">Online</span>
                </div>
            </div>
        </div>
        
        {{-- Messages Container - Scrollable area for conversation history --}}
        <div class="h-100 overflow-scroll">
        <div class="flex-1 overflow-y-auto p-6 space-y-4">
            {{-- 
                Loop through all messages in conversation
                @forelse handles both cases: has messages OR empty
            --}}
            @forelse ($messages as $message)
                {{-- 
                    Check if message is from the selected user (incoming) 
                    OR from current user (outgoing)
                    This determines message alignment and styling
                --}}
                @if ($message->sender_id == $user->id)
                    {{-- Incoming Message - From selected user to current user --}}
                    <div class="flex items-start gap-2.5">
                        {{-- Sender Avatar --}}
                        <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="">
                        {{-- Message Bubble --}}
                        <div class="flex flex-col max-w-xs bg-white dark:bg-gray-700 rounded-lg p-3 shadow">
                            {{-- Message Content --}}
                            <p class="text-sm text-gray-900 dark:text-white">
                                {{ $message->message }}
                            </p>
                            {{-- Timestamp - Shows when message was sent --}}
                            <span class="text-xs text-gray-500 mt-1">{{ $message->created_at->format('h:i A') }}</span>
                        </div>
                    </div>
                @else
                    {{-- Outgoing Message - From current user to selected user --}}
                    <div class="flex justify-end">
                        {{-- Message Bubble - Different styling for sent messages --}}
                        <div class="flex flex-col max-w-xs bg-blue-600 text-white rounded-lg p-3 shadow">
                            {{-- Message Content --}}
                            <p class="text-sm">
                                {{ $message->message }}
                            </p>
                            {{-- Timestamp - Right-aligned for sent messages --}}
                            <span class="text-xs text-blue-200 mt-1 text-right">{{ $message->created_at->format('h:i A') }}</span>
                        </div>
                    </div>
                @endif
            @empty
                {{-- Empty State - No messages in conversation yet --}}
                <div class="text-center text-gray-500 py-8">
                    <p>No messages yet. Start the conversation!</p>
                </div>
            @endforelse
        </div>
        </div>
        {{-- Message Input Form - For sending new messages --}}
        <form action="{{ route('sendMessage') }}" method="POST">
            @csrf {{-- CSRF token for security --}}
            
            {{-- Message Input Container --}}
            <div class="w-full mb-4 border border-gray-300 rounded-lg bg-gray-50 shadow-sm">
                {{-- Toolbar - Action buttons above message input --}}
                <div class="flex items-center justify-between px-3 py-2 border-b border-gray-300">
                    {{-- Left Toolbar Buttons --}}
                    <div class="flex flex-wrap items-center divide-gray-300 sm:divide-x sm:rtl:divide-x-reverse">
                        <div class="flex items-center space-x-1 rtl:space-x-reverse sm:pe-4">
                            {{-- Attach File Button --}}
                            <button type="button" class="p-2 text-gray-600 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8v8a5 5 0 1 0 10 0V6.5a3.5 3.5 0 1 0-7 0V15a2 2 0 0 0 4 0V8" /></svg>
                                <span class="sr-only">Attach file</span>
                            </button>
                            {{-- Location Button --}}
                            <button type="button" class="p-2 text-gray-600 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.8 13.938h-.011a7 7 0 1 0-11.464.144h-.016l.14.171c.1.127.2.251.3.371L12 21l5.13-6.248c.194-.209.374-.429.54-.659l.13-.155Z" /></svg>
                                <span class="sr-only">Embed map</span>
                            </button>
                            {{-- Upload Image Button --}}
                            <button type="button" class="p-2 text-gray-600 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M16 18H8l2.5-6 2 4 1.5-2 2 4Zm-1-8.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z" />
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m14-4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1ZM8 18h8l-2-4-1.5 2-2-4L8 18Zm7-8.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z" /></svg>
                                <span class="sr-only">Upload image</span>
                            </button>
                        </div>
                        {{-- Right Toolbar Buttons --}}
                        <div class="flex flex-wrap items-center space-x-1 rtl:space-x-reverse sm:ps-4">
                            {{-- Add List Button --}}
                            <button type="button" class="p-2 text-gray-600 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6h8m-8 6h8m-8 6h8M4 16a2 2 0 1 1 3.321 1.5L4 20h5M4 5l2-1v6m-2 0h4" /></svg>
                                <span class="sr-only">Add list</span>
                            </button>
                        </div>
                    </div>
                    {{-- Fullscreen Button --}}
                    <button type="button" data-tooltip-target="tooltip-fullscreen" class="p-2 text-gray-600 rounded-sm cursor-pointer sm:ms-auto hover:text-gray-900 hover:bg-gray-100">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H4m0 0v4m0-4 5 5m7-5h4m0 0v4m0-4-5 5M8 20H4m0 0v-4m0 4 5-5m7 5h4m0 0v-4m0 4-5-5" /></svg>
                        <span class="sr-only">Full screen</span>
                    </button>
                    {{-- Tooltip for fullscreen button --}}
                    <div id="tooltip-fullscreen" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                        Show full screen
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>
                
                {{-- Message Input Area --}}
                <div class="px-4 py-2 bg-gray-50 rounded-b-lg">
                    <label for="editor" class="sr-only">Publish post</label>
                    
                    {{-- Hidden Form Fields --}}
                    {{-- Current User ID (sender) --}}
                    <input type="text" name="sender_id" value="{{ Auth::guard('login')->id() }}" hidden>
                    {{-- Selected User ID (receiver) --}}
                    <input type="text" name="receiver_id" value="{{ $id }}" hidden>
                    
                    {{-- Message Textarea --}}
                    <textarea id="editor" name="message" rows="8" class="block w-full px-0 text-sm text-gray-900 bg-gray-50 border-0 focus:ring-0 placeholder:text-gray-500" placeholder="Write a message..." required></textarea>
                </div>
            </div>
            
            {{-- Send Button --}}
            <button type="submit" class="text-white bg-blue-600 box-border border border-transparent hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 shadow-sm font-medium leading-5 rounded-lg text-sm px-4 py-2.5 focus:outline-none">SEND</button>
        </form>

    </div>
</div>
