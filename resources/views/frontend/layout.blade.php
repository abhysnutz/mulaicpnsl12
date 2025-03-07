<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title> | Belajar, Tryout dan Latihan Soal PPPK</title>
        <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
        @stack('css-top')
        {{-- <link rel="stylesheet" href="https://ayopppk.com/css/app.css?id=29fbd4e23cb5e78972c3"> --}}
        <link rel="apple-touch-icon" sizes="180x180" href="https://ayopppk.com/assets/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="https://ayopppk.com/assets/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="https://ayopppk.com/assets/favicon/favicon-16x16.png">
        <link rel="mask-icon" href="https://ayopppk.com/assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <link rel="stylesheet" href="https://ayopppk.com/css/custom.css">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
        <meta name="keywords" content="pppk, p3k, bimbel pppk, tryout pppk, soal pppk, soal p3k, tryout p3k, ayo pppk, info pppk, jadwal pppk, soal pembahasan pppk, materi pppk, soal manajerial, soal sosio kultural, soal teknis, soal skolastik, pppk pgsd, pppk guru, tryout cat">
        <meta name="description" content="AYOPPPK merupakan website belajar online untuk persiapan seleksi PPPK. Belajar secara mudah dan praktis dengan beragam latihan soal CAT PPPK. Dilengkapi dengan pembahasan soal, grafik informatif dan berlatih manajemen waktu.">
        <meta property="og:site_name" content="AYOPPPK">
        <meta property="og:url" content="https://ayopppk.com">
        <meta property="og:title" content="AYOPPPK - Belajar, Tryout dan Latihan Soal PPPK">
        <meta property="og:description" content="AYOPPPK merupakan website belajar online untuk persiapan seleksi PPPK. Belajar secara mudah dan praktis dengan beragam latihan soal CAT PPPK. Dilengkapi dengan pembahasan soal, grafik informatif dan berlatih manajemen waktu.">
        <meta property="og:type" content="website">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body inmaintabuse="1"> 
        <div>
            <div class="h-screen flex overflow-hidden bg-gray-100">
                @if (!Request::is('*prepare*') && !Request::is('*working*'))
                    @include('frontend.navigation')
                @endif
                <div class="flex flex-col w-0 flex-1 overflow-hidden">
                    @if (!Request::is('*prepare*') && !Request::is('*working*'))
                        <div class="relative flex-shrink-0 flex h-16 bg-white shadow">
                            <button class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 lg:hidden sm:flex sm:items-center hidden">
                                <span class="sr-only">Open sidebar</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                </svg>
                            </button>
                            <div class="flex items-center px-4 sm:hidden">
                                <img src="https://ayopppk.com/images/ayopppk.svg?dd3e832aef37338c5f2fc59f875154e1" alt="ayopppk" class="h-10 w-full">
                            </div>
                            <div class="flex-1 px-4 flex justify-between">
                                <div class="flex-1 flex"></div>
                                <div class="ml-4 flex items-center md:ml-6">
                                    <div class="ml-3 relative">
                                        <div>
                                            <button id="user-menu" aria-haspopup="true" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <span class="sr-only">Open user menu</span>
                                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()?->name }}&amp;background=6366f1&amp;color=fff" alt="" class="h-8 w-8 rounded-full">
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
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        @stack('js-bottom')
        <iframe allow="join-ad-interest-group" data-tagging-id="AW-11327116374" data-load-time="1739631326943" height="0" width="0" src="https://td.doubleclick.net/td/rul/11327116374?random=1739631326936&amp;cv=11&amp;fst=1739631326936&amp;fmt=3&amp;bg=ffffff&amp;guid=ON&amp;async=1&amp;gtm=45be52d0za200&amp;gcd=13l3l3l3l1l1&amp;dma=0&amp;tag_exp=102067808~102482433~102539968~102558064~102587591~102605417~102640599&amp;u_w=1536&amp;u_h=864&amp;url=https%3A%2F%2Fayopppk.com%2Fverify-email&amp;ref=https%3A%2F%2Fayopppk.com%2Fdaftar&amp;hn=www.googleadservices.com&amp;frm=0&amp;tiba=%7C%20Belajar%2C%20Tryout%20dan%20Latihan%20Soal%20PPPK&amp;npa=0&amp;pscdl=noapi&amp;auid=316036945.1739498899&amp;uaa=x86&amp;uab=64&amp;uafvl=Not(A%253ABrand%3B99.0.0.0%7CGoogle%2520Chrome%3B133.0.6943.98%7CChromium%3B133.0.6943.98&amp;uamb=0&amp;uam=&amp;uap=Windows&amp;uapv=15.0.0&amp;uaw=0&amp;fledge=1&amp;data=event%3Dgtag.config" style="display: none; visibility: hidden;"></iframe>
        <iframe height="0" width="0" style="display: none; visibility: hidden;"></iframe>
        <div id="torrent-scanner-popup" style="display: none;"></div>
        <div style="display: none" class="ubey-RecordingScreen-count-down ubey-RecordingScreen-count-down-container">
            <style>
                .ubey-RecordingScreen-count-down-container {
                    position: fixed;
                    height: 100vh;
                    width: 100vw;
                    top: 0;
                    left: 0;
                    z-index: 9999999999999;
                    background-color: rgba(0, 0, 0, 0.2);
                }

                .ubey-RecordingScreen-count-down-content {
                    position: absolute;
                    display: flex;
                    top: 50%;
                    left: 50%;
                    justify-content: center;
                    align-items: center;
                    color: white;
                    height: 15em;
                    width: 15em;
                    transform: translate(-50%, -100%);
                    background-color: rgba(0, 0, 0, 0.6);
                    border-radius: 50%;
                }

                #ubey-RecordingScreen-count-count {
                    font-size: 14em;
                    transform: translateY(-2%);
                }
            </style>
            <div class="ubey-RecordingScreen-count-down-content">
                <span id="ubey-RecordingScreen-count-count"></span>
            </div>
        </div>
    </body>
</html>