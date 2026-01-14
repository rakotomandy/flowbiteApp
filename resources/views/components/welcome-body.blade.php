@props(['user'])
<div class="absolute top-3 left-6 w-[80%] ml-[20%] h-[90vh] flex flex-col items-center justify-center gap-6">
    <h1 class="text-center font-bold text-4xl">Welcome to the Chat App</h1>
    <p class="text-blue-300 font-semibold text-4xl">{{ strtoupper($user->name) }}</p>
    <!-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger -->
</div>