<div class="fixed inset-x-0 bottom-0 z-40 sm:hidden">
    <div class="bg-white shadow-md border">
        <div>
            <div role="dialog" aria-modal="true" class="fixed inset-0 flex z-50" style="display: none;">
                <div class="flex-1 flex flex-col w-full h-full fixed inset-x-0 bg-gray-100 animate__animated animate__fadeInUp animate__faster">
                    <div>
                        <div class="bg-gradient-to-br from-blue-500 to-blue-700 h-44 p-3">
                            <div class="flex justify-between">
                                <div></div>
                                <h2 class="text-white text-base font-medium">Akun Saya</h2>
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-6 w-6 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex-shrink-0 group block mt-8">
                                <div class="flex items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()?->name }}&amp;background=fff&amp;color=6366f1" alt="" class="h-11 w-11 rounded-full">
                                    <div class="ml-4">
                                        <p class="text-base font-medium text-white">test</p>
                                        <div class="-mt-1">
                                            <span class="text-sm rounded-full font-medium text-white">{{ Auth::user()?->email }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-3">
                            <div class="bg-white -mt-14 p-2 rounded-lg shadow">
                                <nav class="flex-1 space-y-0.5">
                                    <a href="https://ayopppk.com/user/pembelian" class="bg-white hover:bg-gray-50 text-gray-800 group flex items-center px-1.5 py-1.5 text-sm font-medium justify-between border-b">
                                        <div class="flex items-center">
                                            <div class="rounded-xl mr-2 border-3 p-0.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-gray-800">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                </svg>
                                            </div>Pembelian
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                    <a href="https://ayopppk.com/user/promo" class="bg-white hover:bg-gray-50 text-gray-800 group flex items-center px-1.5 py-1.5 text-sm font-medium justify-between border-b">
                                        <div class="flex items-center">
                                            <div class="rounded-xl mr-2 border-3 p-0.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                                </svg>
                                            </div>Voucher Promo
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                    <a href="https://ayopppk.com/user/referral" class="bg-white hover:bg-gray-50 text-gray-800 group flex items-center px-1.5 py-1.5 text-sm font-medium justify-between border-b">
                                        <div class="flex items-center">
                                            <div class="rounded-xl mr-2 border-3 p-0.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-6 w-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                                </svg>
                                            </div>Referral &amp; Afiliasi
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                    <a href="https://ayopppk.com/user/akun" class="bg-white hover:bg-gray-50 text-gray-800 group flex items-center px-1.5 py-1.5 text-sm font-medium justify-between border-b">
                                        <div class="flex items-center">
                                            <div class="rounded-xl mr-2 border-3 p-0.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-gray-700">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>Pengaturan Akun
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                    <a href="https://api.whatsapp.com/send/?phone=6285183171763&amp;text=Halo%20kak,%20saya%20mau%20tanya%20tentang%20&amp;app_absent=0" target="_blank" class="bg-white hover:bg-gray-50 text-gray-800 group flex items-center px-1.5 py-1.5 text-sm font-medium justify-between border-b">
                                        <div class="flex items-center">
                                            <div class="rounded-xl mr-2 border-3 p-0.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-6 w-6 text-gray-700">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                                </svg>
                                            </div>Bantuan
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                    <a href="https://ayopppk.com/verify-email#" class="bg-white hover:bg-gray-50 text-gray-800 group flex items-center px-1.5 py-1.5 text-sm font-medium justify-between">
                                        <div class="flex items-center">
                                            <div class="rounded-xl mr-2 border-3 p-0.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                            </div>Log out
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                    <a href="{{ route('profile.edit') }}">
                        <div class="w-full flex justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" height="" viewBox="0 0 24 24" class="text-gray-400 group-hover:text-gray-500 mr-3 h-6 w-6" fill="gray" stroker="currentColor">
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
<!---->
<div class="hidden lg:flex lg:flex-shrink-0">
    <div class="flex flex-col w-64">
        <div class="flex flex-col flex-grow border-r border-gray-200 pt-5 pb-4 bg-white overflow-y-auto">
            <div class="flex items-center flex-shrink-0 px-4">
                <img src="https://ayopppk.com/images/ayopppk.svg?dd3e832aef37338c5f2fc59f875154e1" alt="AYOPPPK" class="h-8 w-full">
            </div>
            <div class="mt-5 flex-grow flex flex-col">
                <nav class="flex-1 px-2 bg-white space-y-1">
                    <a href="{{ route('dashboard.index') }}" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="text-gray-400 group-hover:text-gray-500 mr-3 h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg> Home
                    </a>
                    <a href="{{ route('profile.edit') }}" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-400 group-hover:text-gray-500 mr-3 h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg> Profil
                    </a>
                    {{-- <a href="https://ayopppk.com/user/paket" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-400 group-hover:text-gray-500 mr-3 h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg> Beli Paket
                    </a>
                    <a href="{{ route('pembelian.index') }}" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-400 group-hover:text-gray-500 mr-3 h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg> Pembelian
                    </a> --}}
                    <a href="{{ route('tryout.index') }}" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-400 group-hover:text-gray-500 mr-3 h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg> Tryout
                    </a>
                    <a href="{{ route('tryout.result.index') }}" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-gray-400 group-hover:text-gray-500 mr-3 h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg> Hasil Tryout
                    </a>
                    <a href="{{ route('download.index') }}" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" height="" viewBox="0 0 24 24" class="text-gray-400 group-hover:text-gray-500 mr-3 h-6 w-6" fill="none" stroke="currentColor">
                            <path d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2z"></path>
                        </svg> Materi Download
                    </a>
                    @if (Auth::user()?->subscription_status == 'free')
                        <a href="{{ route('petunjuk_upgrade') }}" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="text-gray-400 group-hover:text-gray-500 mr-3 h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg> Petunjuk Upgrade
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="text-gray-400 group-hover:text-gray-500 mr-3 h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H9M4 4h7a2 2 0 012 2v12a2 2 0 01-2 2H4m0-16h7a2 2 0 012 2v12a2 2 0 01-2 2H4"></path>
                            </svg> Logout
                        </button>
                    </form>
                    
                    
                      
                    
                </nav>
            </div>
            <div class="flex-shrink-0 flex p-4">
                <div class="flex-shrink-0 group block bg-indigo-600 rounded-lg shadow-lg w-full p-2">
                    <div class="flex w-full justify-center -mt-8">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-12 w-12 bg-white rounded-full text-indigo-600 borde border-white">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="space-y-3 mt-3">
                        <p class="text-sm font-medium text-white text-center">Apabila Anda mengalami kesulitan, klik tombol berikut</p>
                        <a href="https://api.whatsapp.com/send/?phone=6285183171763&amp;text=Halo%20kak,%20saya%20mau%20tanya%20tentang%20&amp;app_absent=0" target="_blank" class="inline-flex w-full justify-center rounded-md border border-transparent shadow-sm px-5 py-1.5 bg-indigo-200 font-medium text-gray-700 hover:bg-indigo-300 focus:outline-none focus:ring-0 text-sm">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>