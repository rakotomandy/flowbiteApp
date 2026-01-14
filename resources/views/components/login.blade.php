<div class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Login to Your Account</h2>

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            @error('email')
            
            <div class="text-red-500 text-sm border-2 p-2 rounded">{{ $message }}</div>
            @enderror
            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Password -->
            <div class="relative">
                <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                <input type="password" id="password" name="password" placeholder="********" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                <button type="button" id="toggler" class="absolute right-3 top-10 hover:cursor-pointer">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </button>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="remember" class="h-4 w-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-600">
                    <span class="text-gray-700">Remember me</span>
                </label>
                <a href="#" class="text-blue-600 hover:underline text-sm">Forgot password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition">
                Login
            </button>

        </form>

        <!-- Signup Link -->
        <p class="mt-6 text-center text-gray-600">
            Don’t have an account?
            <a href="{{ route('signup') }}" class="text-blue-600 hover:underline">Sign up</a>
        </p>
    </div>

</div>
