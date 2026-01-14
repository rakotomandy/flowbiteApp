<aside class="h-screen w-[20%] bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-slate-200 flex flex-col">
    @if ($errors->any())
    <div class="text-red-600">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Brand -->
    <div class="px-6 py-6 flex items-center gap-3 border-b border-white/10">
        <img src="{{ asset('images/logo.png') }}" class="h-10 w-10 rounded-lg" alt="Logo">
        <div>
            <h1 class="text-lg font-semibold tracking-wide">{{ config('app.name') }}</h1>
            <p class="text-xs text-slate-400">Chat App</p>
        </div>
    </div>

    <!-- Search -->
    <div class="px-6 py-4">
        <form class="max-w-md mx-auto">
            <label for="search" class="block mb-2.5 text-sm font-medium text-heading sr-only ">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" /></svg>
                </div>
                <input type="search" id="search" class="block w-full p-3 ps-9  text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body bg-transparent focus:bg-sky-100" placeholder="Search" required />
                <button type="submit" class="absolute end-1.5 bottom-1.5 text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded text-xs px-3 py-1.5 focus:outline-none">Search</button>
            </div>
        </form>
    </div>

    <!-- Users list (TRANSPARENT) -->
    <div class="flex-1 overflow-y-auto px-4 scrollbar-thin scrollbar-thumb-white/10 scrollbar-track-transparent">
        <ul class="divide-y divide-white/10">

            <!-- User item -->
            <li class="py-3 hover:bg-white/5 rounded-xl px-3 transition">
                <div class="flex items-center gap-3">
                    <img class="w-9 h-9 rounded-full" src="/docs/images/people/profile-picture-1.jpg" alt="">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-white truncate">Neil Sims</p>
                        <p class="text-xs text-slate-400 truncate">email@windster.com</p>
                    </div>
                </div>
            </li>

            <li class="py-3 hover:bg-white/5 rounded-xl px-3 transition">
                <div class="flex items-center gap-3">
                    <img class="w-9 h-9 rounded-full" src="/docs/images/people/profile-picture-3.jpg" alt="">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-white truncate">Bonnie Green</p>
                        <p class="text-xs text-slate-400 truncate">email@windster.com</p>
                    </div>
                </div>
            </li>

            <li class="py-3 hover:bg-white/5 rounded-xl px-3 transition">
                <div class="flex items-center gap-3">
                    <img class="w-9 h-9 rounded-full" src="/docs/images/people/profile-picture-2.jpg" alt="">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-white truncate">Michael Gough</p>
                        <p class="text-xs text-slate-400 truncate">email@windster.com</p>
                    </div>
                </div>
            </li>

            <li class="py-3 hover:bg-white/5 rounded-xl px-3 transition">
                <div class="flex items-center gap-3">
                    <img class="w-9 h-9 rounded-full" src="/docs/images/people/profile-picture-4.jpg" alt="">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-white truncate">Lana Byrd</p>
                        <p class="text-xs text-slate-400 truncate">email@windster.com</p>
                    </div>
                </div>
            </li>

        </ul>
    </div>

    <!-- Footer -->
    <div class="px-4 py-4 border-t border-white/10 space-y-2">
        <button class="w-full flex items-center gap-2 px-4 py-2 rounded-xl text-slate-300 hover:bg-white/5 hover:text-white transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9 9 0 1118.879 6.196 9 9 0 015.12 17.804z" />
            </svg>
            Profile
        </button>

        <button class="w-full flex items-center gap-2 px-4 py-2 rounded-xl text-slate-300 hover:bg-white/5 hover:text-white transition">
            {{-- <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                </svg> --}}
            <svg class="w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M10 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h2m10 1a3 3 0 0 1-3 3m3-3a3 3 0 0 0-3-3m3 3h1m-4 3a3 3 0 0 1-3-3m3 3v1m-3-4a3 3 0 0 1 3-3m-3 3h-1m4-3v-1m-2.121 1.879-.707-.707m5.656 5.656-.707-.707m-4.242 0-.707.707m5.656-5.656-.707.707M12 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>

            Settings
        </button>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 rounded-xl text-red-400 hover:bg-red-500/10 transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                </svg>
                Logout
            </button>
        </form>

    </div>

</aside>
