@props(['user'])
<div class="bg-blue-100 fixed w-[80%] ml-[20%] z-20 top-0 start-0 border-b border-gray-300">
    <!-- Navbar -->
    <nav>
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-7" alt="Flowbite Logo" />
                <span class="self-center text-xl text-gray-900 font-semibold whitespace-nowrap">{{ strtoupper($user->name) }}</span>
            </a>
            <div class="flex items-center md:order-2">
                <button type="button" data-collapse-toggle="navbar-search" aria-controls="navbar-search" aria-expanded="false" class="flex items-center justify-center md:hidden text-gray-600 hover:text-gray-900 bg-transparent box-border border border-transparent hover:bg-gray-100 focus:ring-2 focus:ring-gray-300 font-medium leading-5 rounded-lg text-sm w-10 h-10 focus:outline-none">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" /></svg>
                    <span class="sr-only">Search</span>
                </button>
                <label for="input-group-1" class="sr-only">Your Email</label>
                <div class="relative hidden md:block">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" /></svg>
                    </div>
                    <input type="text" id="input-group-1" class="block w-full ps-9 pe-3 py-2.5 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-2.5 py-2 shadow-sm placeholder:text-gray-500" placeholder="Search">
                </div>
                <button data-collapse-toggle="navbar-search" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-600 rounded-lg md:hidden hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-300" aria-controls="navbar-search" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" /></svg>
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-search">
                <div class="relative mt-3 md:hidden">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" /></svg>
                    </div>
                    <input type="text" id="input-group-1" class="block w-full ps-9 pe-3 py-2.5 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-2.5 py-2 shadow-sm placeholder:text-gray-500" placeholder="Search">
                </div>
                <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-200 rounded-lg md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 bg-transparent ">
                    <li>
                        <a href="#" class="block py-2 px-3 text-white bg-blue-600 rounded md:bg-transparent md:text-blue-600 md:p-0" aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 md:dark:hover:bg-transparent">About</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 md:dark:hover:bg-transparent">Services</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- It always seems impossible until it is done. - Nelson Mandela -->
</div>
