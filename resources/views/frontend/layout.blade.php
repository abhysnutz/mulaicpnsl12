<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title> | Belajar, Tryout dan Latihan Soal CPNS</title>
        <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
        @stack('css-top')
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/frontend/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/frontend/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/frontend/favicon/favicon-16x16.png') }}">
        <link rel="mask-icon" href="{{ asset('assets/frontend/favicon/safari-pinned-tab.svg') }}" color="#f59e0b">
        <link rel="stylesheet" href="{{ asset('assets/frontend/css/custom.css') }}">
        <meta name="msapplication-TileColor" content="#f59e0b">
        <meta name="theme-color" content="#ffffff">
        <meta name="keywords" content="cpns, bimbel cpns, tryout cpns, soal cpns, mulai cpns, info cpns, jadwal cpns, soal pembahasan cpns, materi cpns, soal manajerial, soal sosio kultural, soal teknis, soal skolastik, tryout cat">
        <meta name="description" content="{{ config('app.name') }} merupakan website belajar online untuk persiapan seleksi CPNS. Belajar secara mudah dan praktis dengan beragam latihan soal CAT CPNS. Dilengkapi dengan pembahasan soal, grafik informatif dan berlatih manajemen waktu.">
        <meta property="og:site_name" content="{{ config('app.name') }}">
        <meta property="og:url" content="{{ config('app.url') }}">
        <meta property="og:title" content="{{ config('app.name') }} - Belajar, Tryout dan Latihan Soal CPNS">
        <meta property="og:description" content="{{ config('app.name') }} merupakan website belajar online untuk persiapan seleksi CPNS. Belajar secara mudah dan praktis dengan beragam latihan soal CAT CPNS. Dilengkapi dengan pembahasan soal, grafik informatif dan berlatih manajemen waktu.">
        <meta property="og:type" content="website">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body inmaintabuse="1"> 
        <div>
            <div class="h-screen flex overflow-hidden bg-gray-100">
                @if (!Request::is('*prepare*') && !Request::is('*working*') && !Request::is('*preview*'))
                    @include('frontend.navigation')
                @endif
                <div class="flex flex-col w-0 flex-1 overflow-hidden">
                    @if (!Request::is('*prepare*') && !Request::is('*working*') && !Request::is('*preview*'))
                        <div class="relative flex-shrink-0 flex h-16 bg-white shadow">
                            <button id="drawer-open" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-amber-500 lg:hidden sm:flex sm:items-center hidden">
                                <span class="sr-only">Open sidebar</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                </svg>
                            </button>
                            <div class="flex items-center px-4 sm:hidden">
                                <img src="{{ asset('assets/frontend/image/logo.png') }}" alt="mulaicpns" class="h-10 w-full">
                            </div>
                            <div class="flex-1 px-4 flex justify-between">
                                <div class="flex-1 flex"></div>
                                <div class="ml-4 flex items-center md:ml-6">
                                    <div class="ml-3 relative">
                                        <div>
                                            <button id="user-menu" aria-haspopup="true" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                                <span class="sr-only">Open user menu</span>
                                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()?->name }}&background=f59e0b&color=fff&bold=true" alt="" class="h-8 w-8 rounded-full">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <main tabindex="0" class="flex-1 relative overflow-y-auto focus:outline-none">
                       @yield('content')
                    </main>
                </div>
            </div>
        </div>
        <script src="{{ asset('assets/frontend/js/jquery-3.7.1.min.js') }}"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(function () {
                function openDrawer()  { $('#mobile-drawer').removeClass('hidden'); }
                function closeDrawer() { $('#mobile-drawer').addClass('hidden'); }

                $(document).on('click', '#drawer-open', openDrawer);
                $(document).on('click', '#drawer-close', closeDrawer);
                $(document).on('click', '#drawer-overlay', closeDrawer);

                $(document).on('keydown', function (e) {
                    if (e.key === 'Escape') closeDrawer();
                });
            });
        </script>
        @stack('js-bottom')
    </body>
</html>