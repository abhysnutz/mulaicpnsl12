<!-- PHONE -->
<div class="fixed inset-x-0 bottom-0 z-40 sm:hidden">
    <div class="bg-white shadow-md border">
        <div>
            <div class="max-w-7xl mx-auto py-2 px-5">
                <div class="flex items-center justify-between flex-wrap">
                    <a href="{{ route('dashboard.index') }}">
                        <div class="w-full flex justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-700 h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <p class="mt-1 font-medium text-xs text-gray-700">Home</p>
                    </a>
                    <a href="{{ route('profile.edit') }}">
                        <div class="w-full flex justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-700 h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <p class="mt-1 font-medium text-xs text-gray-700">Profil</p>
                    </a>
                    <a href="{{ route('tryout.index') }}">
                        <div class="w-full flex justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-700 h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                        </div>
                        <p class="mt-1 font-medium text-xs text-gray-700">Tryout</p>
                    </a>
                    <a href="{{ route('tryout.result.index') }}">
                        <div class="w-full flex justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-gray-400 group-hover:text-gray-500 mr-3 h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <p class="mt-1 font-medium text-xs text-gray-700">Hasil Tryout</p>
                    </a>
                    <a href="{{ route('download.index') }}">
                        <div class="w-full flex justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="text-gray-700 h-6 w-6" fill="gray">
                                <path d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2z"></path>
                            </svg>
                        </div>
                        <p class="mt-1 font-medium text-xs text-gray-700">Materi Download</p>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <div class="w-full flex justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="text-gray-400 group-hover:text-gray-500 mr-3 h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H9M4 4h7a2 2 0 012 2v12a2 2 0 01-2 2H4m0-16h7a2 2 0 012 2v12a2 2 0 01-2 2H4"></path>
                            </svg>
                        </div>
                        <p class="mt-1 font-medium text-xs text-gray-700">Logout</p>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TABLET -->
<div id="mobile-drawer" class="lg:hidden hidden">
    <div class="fixed inset-0 flex z-40">
        <div id="drawer-overlay" aria-hidden="true" class="fixed inset-0">
            <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
        </div>
        <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-white">
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button id="drawer-close" type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <span class="sr-only">Close sidebar</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="h-6 w-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="flex items-center justify-center flex-shrink-0 px-4">
                <img src="{{ asset('assets/frontend/image/logo.png') }}" alt="{{ config('app.name') }}" class="h-12">
            </div>

            <div class="mt-5 flex-1 h-0 overflow-y-auto">
                <nav class="px-2 space-y-1">
                    <a href="{{ route('dashboard.index') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('dashboard.index') ? 'bg-amber-100 text-gray-900' : 'text-gray-600 hover:bg-amber-100 hover:text-gray-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="mr-3 h-6 w-6 {{ request()->routeIs('dashboard.index') ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500' }}">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg> Home
                    </a>
                    <a href="{{ route('profile.edit') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('profile.edit') ? 'bg-amber-100 text-gray-900' : 'text-gray-600 hover:bg-amber-100 hover:text-gray-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="mr-3 h-6 w-6 {{ request()->routeIs('profile.edit') ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500' }}">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg> Profil
                    </a>
                    <a href="{{ route('tryout.index') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('tryout.index') ? 'bg-amber-100 text-gray-900' : 'text-gray-600 hover:bg-amber-100 hover:text-gray-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="mr-3 h-6 w-6 {{ request()->routeIs('tryout.index') ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500' }}">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg> Tryout
                    </a>
                    <a href="{{ route('tryout.result.index') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('tryout.result.index') ? 'bg-amber-100 text-gray-900' : 'text-gray-600 hover:bg-amber-100 hover:text-gray-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="mr-3 h-6 w-6 {{ request()->routeIs('tryout.result.index') ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500' }}">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg> Hasil Tryout
                    </a>
                    <a href="{{ route('download.index') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('download.index') ? 'bg-amber-100 text-gray-900' : 'text-gray-600 hover:bg-amber-100 hover:text-gray-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="mr-3 h-6 w-6 {{ request()->routeIs('download.index') ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500' }}">
                            <path d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2z"></path>
                        </svg> Materi Download
                    </a>

                    @if (Auth::user()?->subscription_status == 'free')
                        <a href="{{ route('petunjuk_upgrade') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('petunjuk_upgrade') ? 'bg-amber-100 text-gray-900' : 'text-gray-600 hover:bg-amber-100 hover:text-gray-900' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="mr-3 h-6 w-6 {{ request()->routeIs('petunjuk_upgrade') ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg> Petunjuk Upgrade
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-gray-600 hover:bg-amber-100 hover:text-gray-900 group flex items-center px-2 py-2 text-base font-medium rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="text-gray-400 group-hover:text-gray-500 mr-3 h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H9M4 4h7a2 2 0 012 2v12a2 2 0 01-2 2H4m0-16h7a2 2 0 012 2v12a2 2 0 01-2 2H4"></path>
                            </svg> Logout
                        </button>
                    </form>
                </nav>
            </div>

            <div class="flex-shrink-0 flex p-4">
                <div class="flex-shrink-0 group block bg-amber-500 rounded-lg shadow-lg w-full p-2">
                    <div class="flex w-full justify-center -mt-8">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-12 w-12 bg-white rounded-full text-amber-500 borde border-white">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="space-y-3 mt-3">
                        <p class="text-sm font-medium text-white text-center">Apabila Anda mengalami kesulitan, klik tombol berikut</p>
                        <a href="https://api.whatsapp.com/send/?phone={{ config('services.admin_whatsapp') }}&text={{ rawurlencode('Halo kak, saya mau tanya tentang ') }}&app_absent=0" target="_blank" class="inline-flex w-full justify-center rounded-md border border-transparent shadow-sm px-5 py-1.5 bg-amber-200 font-medium text-gray-700 hover:bg-amber-300 focus:outline-none focus:ring-0 text-sm">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
        <div aria-hidden="true" class="flex-shrink-0 w-14"></div>
    </div>
</div>

<!-- FULL SIZE -->
<div class="hidden lg:flex lg:flex-shrink-0">
    <div class="flex flex-col w-64">
        <div class="flex flex-col flex-grow border-r border-gray-200 pt-5 pb-4 bg-white overflow-y-auto">
            <div class="flex items-center justify-center flex-shrink-0 px-4">
                <img src="{{ asset('assets/frontend/image/logo.png') }}" 
                    alt="{{ config('app.name') }}" 
                    class="h-12">
            </div>
            <div class="mt-5 flex-grow flex flex-col">
                <nav class="flex-1 px-2 bg-white space-y-1">
                    <a href="{{ route('dashboard.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard.index') ? 'bg-amber-100 text-gray-900' : 'text-gray-600 hover:bg-amber-100 hover:text-gray-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="mr-3 h-6 w-6 {{ request()->routeIs('dashboard.index') ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500' }}">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg> Home
                    </a>
                    <a href="{{ route('profile.edit') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('profile.edit') ? 'bg-amber-100 text-gray-900' : 'text-gray-600 hover:bg-amber-100 hover:text-gray-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="mr-3 h-6 w-6 {{ request()->routeIs('profile.edit') ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500' }}">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg> Profil
                    </a>
                    <!-- Tryout -->
                    <a href="{{ route('tryout.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('tryout.index') ? 'bg-amber-100 text-gray-900' : 'text-gray-600 hover:bg-amber-100 hover:text-gray-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="mr-3 h-6 w-6 {{ request()->routeIs('tryout.index') ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500' }}">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg> Tryout
                    </a>

                    <!-- Hasil Tryout -->
                    <a href="{{ route('tryout.result.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('tryout.result.index') ? 'bg-amber-100 text-gray-900' : 'text-gray-600 hover:bg-amber-100 hover:text-gray-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="mr-3 h-6 w-6 {{ request()->routeIs('tryout.result.index') ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500' }}">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg> Hasil Tryout
                    </a>

                    <!-- Materi Download -->
                    <a href="{{ route('download.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('download.index') ? 'bg-amber-100 text-gray-900' : 'text-gray-600 hover:bg-amber-100 hover:text-gray-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="mr-3 h-6 w-6 {{ request()->routeIs('download.index') ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500' }}">
                            <path d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2z"></path>
                        </svg> Materi Download
                    </a>

                    @if (Auth::user()?->subscription_status == 'free')
                        <a href="{{ route('petunjuk_upgrade') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('petunjuk_upgrade') ? 'bg-amber-100 text-gray-900' : 'text-gray-600 hover:bg-amber-100 hover:text-gray-900' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="mr-3 h-6 w-6 {{ request()->routeIs('petunjuk_upgrade') ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg> Petunjuk Upgrade
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-gray-600 hover:bg-amber-100 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="text-gray-400 group-hover:text-gray-500 mr-3 h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H9M4 4h7a2 2 0 012 2v12a2 2 0 01-2 2H4m0-16h7a2 2 0 012 2v12a2 2 0 01-2 2H4"></path>
                            </svg> Logout
                        </button>
                    </form>
                    
                </nav>
            </div>
            <div class="flex-shrink-0 flex p-4">
                <div class="flex-shrink-0 group block bg-amber-500 rounded-lg shadow-lg w-full p-2">
                    <div class="flex w-full justify-center -mt-8">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-12 w-12 bg-white rounded-full text-amber-500 borde border-white">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="space-y-3 mt-3">
                        <p class="text-sm font-medium text-white text-center">Apabila Anda mengalami kesulitan, klik tombol berikut</p>
                        <a href="https://api.whatsapp.com/send/?phone={{ config('services.admin_whatsapp') }}&text={{ rawurlencode('Halo kak, saya mau tanya tentang ') }}&app_absent=0" target="_blank" class="inline-flex w-full justify-center rounded-md border border-transparent shadow-sm px-5 py-1.5 bg-amber-200 font-medium text-gray-700 hover:bg-amber-300 focus:outline-none focus:ring-0 text-sm">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>