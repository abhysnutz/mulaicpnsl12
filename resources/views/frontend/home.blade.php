<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ env('APP_NAME') }} | Belajar dan Latihan Soal Tryout CPNS</title>
        <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="https://ayopppk.com/assets/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/frontend/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/frontend/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="https://ayopppk.com/assets/favicon/site.webmanifest">
        <link rel="mask-icon" href="https://ayopppk.com/assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
        <meta name="keywords" content="pppk, p3k, bimbel pppk, tryout pppk, soal pppk, soal p3k, tryout p3k, ayo pppk, info pppk, jadwal pppk, soal pembahasan pppk, materi pppk, soal manajerial, soal sosio kultural, soal teknis, soal skolastik, pppk pgsd, pppk guru, tryout cat">
        <meta name="description" content="{{ env('APP_NAME') }} merupakan website belajar online untuk persiapan seleksi PPPK. Belajar secara mudah dan praktis dengan beragam latihan soal CAT PPPK. Dilengkapi dengan pembahasan soal, grafik dan berlatih manajemen waktu.">
        <meta property="og:site_name" content="{{ env('APP_NAME') }}">
        <meta property="og:url" content="{{ env('APP_URL') }}">
        <meta property="og:title" content="{{ env('APP_NAME') }} - Belajar, Tryout dan Latihan Soal PPPK">
        <meta property="og:description" content="{{ env('APP_NAME') }} adalah website belajar online untuk persiapan seleksi PPPK. Belajar secara mudah dan praktis dengan beragam latihan soal CAT PPPK. Dilengkapi dengan pembahasan soal, grafik dan berlatih manajemen waktu.">
        <meta property="og:type" content="website">
    </head>
    <body>
        <div class="min-h-screen">
            <div class="relative overflow-hidden">
                <div class="relative pt-6 pb-0">
                    <header class="fixed top-0 right-0 left-0 flex z-10 bg-white shadow">
                        <nav class="relative max-w-7xl mx-auto w-full flex items-center justify-between px-4 sm:px-6 py-4" aria-label="Global">
                            <div class="flex items-center flex-1">
                                <div class="flex items-center justify-between w-full md:w-auto">
                                    <a href="#">
                                        <span class="sr-only">{{ env('APP_NAME') }}</span>
                                        <img class="h-8 w-auto sm:h-10" src="{{ asset('assets/frontend/image/logo.png') }}" alt="">
                                    </a>
                                    <div class="-mr-2 flex items-center md:hidden">
                                        <button id="mobileNavExpandBtn" type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-amber-500" aria-expanded="false">
                                            <span class="sr-only">Open main menu</span>
                                            <!-- Heroicon name: outline/menu -->
                                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="hidden md:block md:ml-10 md:space-x-10">
                                    <a href="#home" class="font-medium text-gray-500 hover:text-gray-900">Tentang</a>
                                    <a href="#fitur" class="font-medium text-gray-500 hover:text-gray-900">Fitur</a>
                                    <a href="#paket" class="font-medium text-gray-500 hover:text-gray-900">Paket</a>
                                    <!-- <a href="#faq" class="font-medium text-gray-500 hover:text-gray-900">Pertanyaan Umum</a> -->
                                </div>
                            </div>
                            <div class="hidden md:block text-right">
                                <span class="inline-flex  space-x-6">
                                    <a href="#" class="umami--click--landing-contact-button inline-flex items-center px-4 py-2 border border-amber-500 text-base font-medium rounded-md text-white bg-amber-500 hover:bg-amber-700 hover:text-white" target="_blank"> Hubungi Kami </a>
                                </span>
                            </div>
                        </nav>
                    </header>
                    <div id="mobileNav" class="fixed z-50 top-0 inset-x-0 p-2 transition transform origin-top-right hidden md:hidden">
                        <div class="rounded-lg shadow-md bg-white ring-1 ring-black ring-opacity-5 overflow-hidden">
                            <div class="px-5 pt-4 flex items-center justify-between">
                                <div>
                                    <img class="h-8 w-auto" src="{{ asset('assets/frontend/image/logo.png') }}" alt="">
                                </div>
                                <div class="-mr-2">
                                    <button type="button" id="mobileNavCloseBtn" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                        <span class="sr-only">Close main menu</span>
                                        <!-- Heroicon name: outline/x -->
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="px-2 pt-2 pb-3 space-y-1">
                                <a href="#home" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Tentang</a>
                                <a href="#fitur" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Fitur</a>
                                <a href="#paket" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Paket</a>
                            </div>
                            <div class="px-3">
                                <a href="{{ route('login') }}" class="block w-full px-5 py-3 text-center font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded mb-3"> Masuk 2</a>
                                <a href="{{ route('register') }}" class="block w-full px-5 py-3 text-center font-medium text-indigo-600 bg-white-50 border-2 border-indigo-400 hover:bg-indigo-50 rounded mb-3 "> Daftar </a>
                            </div>
                        </div>
                    </div>
                    <div id="home" class="bg-white pb-8 sm:pb-12 lg:pb-12">
                        <div class="pt-8 overflow-hidden sm:pt-12 lg:relative lg:py-48">
                            <div class="mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl lg:grid lg:grid-cols-2 lg:gap-24">
                                <div>
                                    <div class="hidden md:block">
                                        <img class="h-11 w-auto" src="{{ asset('assets/frontend/favicon/favicon-44x44.png') }}" alt="Workflow" />
                                    </div>
                                    <div class="mt-20">
                                        <div class="relative pl-0 sm:hidden  sm:mx-auto sm:max-w-3xl sm:px-0 lg:max-w-none lg:h-full lg:pl-0 mb-4">
                                            <img class="w-full rounded-md lg:h-auto lg:w-auto lg:max-w-4xl lg:-ml-8 lg:mt-5" src="https://ayopppk.com/assets/hero/heropppk.png" alt="Latihan Soal PPPK" />
                                        </div>
                                        <div>
                                            <a href="#" class="inline-flex space-x-4">
                                                <span class="rounded bg-amber-100 px-2.5 py-1 text-xs font-semibold text-indigo-600 tracking-wide uppercase"> Belajar Jadi Mudah </span>
                                                <span class="inline-flex items-center text-sm font-medium text-indigo-600 space-x-1">
                                                    <span>{{ env('APP_NAME') }}</span>
                                                    <!-- Heroicon name: solid/chevron-right -->
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </a>
                                        </div>
                                        <div class="mt-6 sm:max-w-xl">
                                            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl"> Ayo Lulus CPNS {{ date('Y') }} bersama {{ env('APP_NAME') }}! </h1>
                                            <p class="mt-6 text-xl text-gray-500"> Tempat tepat untuk curi start belajar persiapan seleksi CPNS! </p>
                                        </div>
                                        <div class="mt-4 sm:mt-6">
                                            <div class="sm:max-w-xl flex flex-col">
                                                <div class="sm:space-y-0 flex justify-start items-center sm:inline-grid sm:grid-cols-2 sm:gap-5 mr-auto">
                                                    <a href="{{ route('login') }}" class="umami--click--hero-login-button flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-amber-600 bg-white border-amber-500 hover:bg-amber-100 sm:px-8 mr-3 md:mr-0"> Masuk </a>
                                                    <a href="{{ route('register') }}" class="umami--click--hero-register-button flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-amber-500 hover:bg-opacity-70 sm:px-8"> Daftar </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sm:mx-auto sm:max-w-3xl sm:px-6">
                                <div class="py-12 sm:relative sm:mt-12 sm:py-16 lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
                                    <div class="hidden sm:block">
                                        <div class="absolute inset-y-0 left-1/2 w-screen bg-gray-50 rounded-l-3xl lg:left-80 lg:right-0 lg:w-full"></div>
                                        <svg class="absolute top-8 right-1/2 -mr-3 lg:m-0 lg:left-0" width="404" height="392" fill="none" viewBox="0 0 404 392">
                                            <defs>
                                                <pattern id="837c3e70-6c3a-44e6-8854-cc48c737b659" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                                    <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                                                </pattern>
                                            </defs>
                                            <rect width="404" height="392" fill="url(#837c3e70-6c3a-44e6-8854-cc48c737b659)" />
                                        </svg>
                                    </div>
                                    <div class="relative pl-0 hidden sm:block  sm:mx-auto sm:max-w-3xl sm:px-0 lg:max-w-none lg:h-full lg:pl-0">
                                        <img class="w-full rounded-md lg:h-auto lg:w-auto lg:max-w-4xl lg:-ml-8 lg:mt-5" src="https://ayopppk.com/assets/hero/heropppk.png" alt="Latihan Soal PPPK" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <main>
                        <!-- Alternating Feature Sections -->
                        <div class="relative pt-16 pb-32 overflow-hidden">
                            <div aria-hidden="true" class="absolute inset-x-0 top-0 h-48 bg-gradient-to-b from-gray-100"></div>
                            <div class="relative">
                                <div class="lg:mx-auto lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-24">
                                    <div class="px-4 max-w-xl mx-auto sm:px-6 lg:py-16 lg:max-w-none lg:mx-0 lg:px-0">
                                        <div>
                                            <div>
                                                <span class="h-12 w-12 rounded-md flex items-center justify-center bg-gradient-to-r bg-amber-500">
                                                    <!-- Heroicon name: outline/globe -->
                                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="mt-6">
                                                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900"> 1 Juta Formasi CPNS di Tahun {{ date('Y') }} </h2>
                                                <p class="mt-4 text-lg text-gray-500"> Pemerintah akan membuka penerimaan 1 juta pegawai aparatur sipil negara (ASN). </p>
                                                <p class="mt-4 text-lg text-gray-500"> Persiapkan diri Anda sekarang! Waktu tidak berjalan mundur. Mulai asah kemampuan berpikir dan memahami soal. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-12 sm:mt-16 lg:mt-0">
                                        <div class="pl-4  sm:pl-6 md:-mr-16 lg:px-0 lg:m-0 lg:relative lg:h-full">
                                            <img class="w-full rounded-xl lg:absolute lg:left-0 lg:h-full lg:w-auto lg:max-w-none" src="https://ayopppk.com/assets/illustrations/undraw_stand_out.svg" alt="Penerimaan Formasi PPPK 2021" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-24">
                                <div class="lg:mx-auto lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-24">
                                    <div class="px-4 max-w-xl mx-auto sm:px-6 lg:py-32 lg:max-w-none lg:mx-0 lg:px-0 lg:col-start-2">
                                        <div>
                                            <div>
                                                <span class="h-12 w-12 rounded-md flex items-center justify-center bg-gradient-to-r bg-amber-500">
                                                    <!-- Heroicon name: outline/sparkles -->
                                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="mt-6">
                                                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900"> Kenapa belajar di <strong class="text-amber-500">{{ env('APP_NAME') }} ?</strong>
                                                </h2>
                                                <p class="mt-4 text-lg text-gray-500"> Saat kamu sedang bersantai, jutaan pesaing kamu sedang belajar dengan giat. Apabila tidak segera bergerak, kamu akan tertinggal. {{ env('APP_NAME') }} ingin menjadi teman belajar kamu! Temukan kemudahan dan pengalaman belajar praktis di sini. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-12 sm:mt-16 lg:mt-0 lg:col-start-1">
                                        <div class="pr-4 sm:pr-6 md:-ml-16 lg:px-0 lg:m-0 lg:relative lg:h-full">
                                            <img class="w-full rounded-xl lg:absolute lg:right-0 lg:h-full lg:w-auto lg:max-w-none" src="https://ayopppk.com/assets/illustrations/undraw_teacher.svg" alt="Bimbel Tes PPPK Terbaik" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="fitur" class="py-16 bg-gray-50 overflow-hidden lg:py-24">
                            <div class="relative max-w-xl mx-auto px-4 sm:px-6 lg:px-8 lg:max-w-7xl">
                                <svg class="hidden lg:block absolute left-full transform -translate-x-1/2 -translate-y-1/4" width="404" height="784" fill="none" viewBox="0 0 404 784" aria-hidden="true">
                                    <defs>
                                        <pattern id="b1e6e422-73f8-40a6-b5d9-c8586e37e0e7" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                            <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                                        </pattern>
                                    </defs>
                                    <rect width="404" height="784" fill="url(#b1e6e422-73f8-40a6-b5d9-c8586e37e0e7)" />
                                </svg>
                                <div class="relative">
                                    <h2 class="text-center text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl"> Fitur {{ env('APP_NAME') }} </h2>
                                    <p class="mt-4 max-w-3xl mx-auto text-center text-xl text-gray-500"> Apa saja fitur dan fasilitas di {{ env('APP_NAME') }}? </p>
                                </div>
                                <div class="relative mt-12 lg:mt-24 lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
                                    <div class="relative">
                                        <dl class="mt-10 space-y-10">
                                            <div class="relative">
                                                <dt>
                                                    <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-amber-500 text-white">
                                                        <!-- Heroicon name: outline/desktop-computer -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900"> Latihan CAT (Computer Assisted Test) </p>
                                                </dt>
                                                <dd class="mt-2 ml-16 text-base text-gray-500"> Asah kemampuan berpikir dengan mengerjakan paket Latihan. Kamu bisa mempelajari dan memahami berbagai variasi soal seperti kompetensi teknis, manajerial dan sosio kultural. </dd>
                                            </div>
                                            <div class="relative">
                                                <dt>
                                                    <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-amber-500 text-white">
                                                        <!-- Heroicon name: outline/chart-pie -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                                        </svg>
                                                    </div>
                                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900"> Grafik Hasil Latihan yang Informatif </p>
                                                </dt>
                                                <dd class="mt-2 ml-16 text-base text-gray-500"> Kenali kelemahanmu! Kamu akan lebih mudah mengukur kemampuan untuk setiap bagian soal. {{ env('APP_NAME') }} menyediakan grafik hasil Latihan yang informatif. Kamu bisa memanfaatkan fitur ini untuk mengevaluasi hasil belajar serta memperbaiki kelemahan kamu. </dd>
                                            </div>
                                            <div class="relative">
                                                <dt>
                                                    <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-amber-500 text-white">
                                                        <!-- Heroicon name: outline/clock -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900"> Berlatih Manajemen Waktu </p>
                                                </dt>
                                                <dd class="mt-2 ml-16 text-base text-gray-500"> Mengerjakan soal dengan benar saja juga belum cukup! Saat tes nanti kamu akan dibatasi oleh waktu. {{ env('APP_NAME') }} menyediakan fasilitas analisa waktu untuk membantu kamu mengetahui berapa lama waktu yang kamu habiskan untuk mengerjakan di setiap soal. Sehingga saat tes nanti kamu lebih siap dan dapat mengantisipasi kekurangan waktu. </dd>
                                            </div>
                                        </dl>
                                    </div>
                                    <div class="mt-10 -mx-4 relative lg:mt-0" aria-hidden="true">
                                        <!-- <svg class="absolute left-1/2 transform -translate-x-1/2 translate-y-16 lg:hidden" width="784" height="404" fill="none" viewBox="0 0 784 404"><defs><pattern id="ca9667ae-9f92-4be7-abcb-9e3d727f2941" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" /></pattern></defs><rect width="784" height="404" fill="url(#ca9667ae-9f92-4be7-abcb-9e3d727f2941)" /></svg><img class="relative mx-auto" width="490" src="https://tailwindui.com/img/features/feature-example-1.png" alt="" /> -->
                                        <div class="relative mb-10">
                                            <dt>
                                                <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-amber-500 text-white mb-3">
                                                    <!-- Heroicon name: outline/check-circle -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <p class="ml-16 text-lg leading-6 font-medium text-gray-900"> Akses Belajar Fleksibel </p>
                                            </dt>
                                            <dd class="mt-2 ml-16 text-base text-gray-500"> Kami memahami kesibukan kamu. Sebagian mungkin sedang sibuk bekerja, sebagian lainnya merawat buah hati. {{ env('APP_NAME') }} adalah solusi. Kamu dapat mengakses kapan saja dan di mana saja secara praktis. {{ env('APP_NAME') }} dapat diakses menggunakan komputer, laptop maupun smartphone. Apabila mengerjakan Latihan dirasa terlalu lama? Tenang, kamu bisa mengerjakan di bagian tertentu saja. Menyenangkan, bukan? </dd>
                                        </div>
                                        <div class="relative">
                                            <dt>
                                                <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-amber-500 text-white">
                                                    <!-- Heroicon name: outline/emoji-happy -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <p class="ml-16 text-lg leading-6 font-medium text-gray-900"> Tampilan Simpel dan Mudah Digunakan </p>
                                            </dt>
                                            <dd class="mt-2 ml-16 text-base text-gray-500"> Belum terbiasa belajar secara online? Jangan khawatir, {{ env('APP_NAME') }} telah memikirkan solusi masalah tersebut. Kami mendesain tampilan yang sederhana, bersih dan mudah digunakan. Sehingga kamu akan nyaman saat sedang belajar dan mengerjakan soal. </dd>
                                        </div>
                                    </div>
                                </div>
                                <svg class="hidden lg:block absolute right-full transform translate-x-1/2 translate-y-12" width="404" height="784" fill="none" viewBox="0 0 404 784" aria-hidden="true">
                                    <defs>
                                        <pattern id="64e643ad-2176-4f86-b3d7-f2c5da3b6a6d" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                            <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                                        </pattern>
                                    </defs>
                                    <rect width="404" height="784" fill="url(#64e643ad-2176-4f86-b3d7-f2c5da3b6a6d)" />
                                </svg>
                            </div>
                        </div>
                        <!-- List Pricing -->
                        <!-- This example requires Tailwind CSS v2.0+ -->
                        <div id="paket" class="bg-gray-100">
                            <div class="pt-12 sm:pt-16 lg:pt-20">
                                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                                    <div class="text-center">
                                        <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl lg:text-5xl"> Harga Terjangkau </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8 bg-white pb-16 sm:mt-12 sm:pb-20 lg:pb-28">
                                <div class="relative">
                                    <div class="absolute inset-0 h-1/2 bg-gray-100"></div>
                                    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                                        <div class="max-w-lg mx-auto rounded-lg shadow-lg overflow-hidden lg:max-w-none lg:flex">
                                            <div class="flex-1 bg-white px-6 py-8 lg:p-12">
                                                <h3 class="text-2xl font-extrabold text-gray-900 sm:text-3xl"> Dapatkan Harga Spesial </h3>
                                                <div class="mt-8">
                                                    <div class="flex items-center">
                                                        <h4 class="flex-shrink-0 pr-4 bg-white text-sm tracking-wider font-semibold uppercase text-indigo-600"> Fasilitas yang didapat </h4>
                                                        <div class="flex-1 border-t-2 border-gray-200"></div>
                                                    </div>
                                                    <ul class="mt-8 space-y-5 lg:space-y-0 lg:grid lg:grid-cols-2 lg:gap-x-8 lg:gap-y-5">
                                                        <li class="flex items-start lg:col-span-1">
                                                            <div class="flex-shrink-0">
                                                                <!-- Heroicon name: solid/check-circle -->
                                                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                            <p class="ml-3 text-sm text-gray-700"> Full Akses selama 12 Bulan </p>
                                                        </li>
                                                        <li class="flex items-start lg:col-span-1">
                                                            <div class="flex-shrink-0">
                                                                <!-- Heroicon name: solid/check-circle -->
                                                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                            <p class="ml-3 text-sm text-gray-700"> Kunci Jawaban dan Pembahasan </p>
                                                        </li>
                                                        <li class="flex items-start lg:col-span-1">
                                                            <div class="flex-shrink-0">
                                                                <!-- Heroicon name: solid/check-circle -->
                                                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                            <p class="ml-3 text-sm text-gray-700"> Berlatih Manajemen Waktu </p>
                                                        </li>
                                                        <li class="flex items-start lg:col-span-1">
                                                            <div class="flex-shrink-0">
                                                                <!-- Heroicon name: solid/check-circle -->
                                                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                            <p class="ml-3 text-sm text-gray-700"> Praktis dan Simpel </p>
                                                        </li>
                                                        <li class="flex items-start lg:col-span-1">
                                                            <div class="flex-shrink-0">
                                                                <!-- Heroicon name: solid/check-circle -->
                                                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                            <p class="ml-3 text-sm text-gray-700"> Tampilan Sederhana dan Elegan </p>
                                                        </li>
                                                        <li class="flex items-start lg:col-span-1">
                                                            <div class="flex-shrink-0">
                                                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                            <p class="ml-3 text-sm text-gray-700"> Latihan Sistem CAT & Realtime </p>
                                                        </li>
                                                        <li class="flex items-start lg:col-span-1">
                                                            <div class="flex-shrink-0">
                                                                <!-- Heroicon name: solid/check-circle -->
                                                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                            <p class="ml-3 text-sm text-gray-700"> Skor dan Grafik Informatif </p>
                                                        </li>
                                                        <!-- <li class="flex items-start lg:col-span-1"><div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400"
																																		xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg></div><p class="ml-3 text-sm text-gray-700">
                              Grafik Analisa Waktu
                            </p></li> -->
                                                        <li class="flex items-start lg:col-span-1">
                                                            <div class="flex-shrink-0">
                                                                <!-- Heroicon name: solid/check-circle -->
                                                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                            <p class="ml-3 text-sm text-gray-700"> Akses di Smartphone, Laptop atau Komputer </p>
                                                        </li>
                                                        <li class="flex items-start lg:col-span-1">
                                                            <div class="flex-shrink-0">
                                                                <!-- Heroicon name: solid/check-circle -->
                                                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                            <p class="ml-3 text-sm text-gray-700"> Mendukung Beragam Metode Pembayaran <br> (Virtual Account, E-Wallet dan Alfamart) </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="py-8 px-6 text-center bg-gray-50 lg:flex-shrink-0 lg:flex lg:flex-col lg:justify-center lg:p-12">
                                                <!-- HEADLINE PROMO -->
                                                <p class="text-3xl font-extrabold text-red-600 mb-2 tracking-wide">
                                                    PROMO TERBATAS 💥
                                                </p>
                                                <p class="text-sm text-gray-600 mb-4">
                                                    Hemat hingga 80% — Akses Premium Selama 1 Tahun
                                                </p>

                                                <!-- HARGA -->
                                                <p class="text-lg leading-6 font-medium text-gray-900 line-through text-center px-4">
                                                    Rp249.000
                                                </p>
                                                <div class="flex items-center justify-center text-5xl font-extrabold text-gray-900">
                                                    <span> Rp50.000 </span>
                                                </div>

                                                <!-- CTA BUTTON -->
                                                <div class="mt-6">
                                                    <div class="rounded-md shadow">
                                                        <a href="http://mulaicpnsid.test/register" 
                                                        class="umami--click--pricing-action-button flex items-center justify-center px-5 py-3 border border-transparent text-lg font-semibold rounded-md text-white bg-red-600 hover:bg-red-700 transition">
                                                            Ambil Promo Sekarang 🚀
                                                        </a>
                                                    </div>
                                                </div>

                                               
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End List Pricing -->
                        <!-- List Formasi Section -->
                        <!-- This example requires Tailwind CSS v2.0+ -->
                        <div class="relative bg-white py-16 sm:py-24 lg:py-32">
                            <div class="mx-auto max-w-md px-4 text-center sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl">
                                <h2 class="text-base font-semibold tracking-wider text-indigo-600 uppercase">Apa saja yang dipelajari?</h2>
                                <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl"></p>
                                <div class="mt-12">
                                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                                        <div class="pt-6">
                                            <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                                <div class="-mt-6">
                                                    <div>
                                                        <span class="inline-flex items-center justify-center p-3 bg-amber-500 rounded-md shadow-lg">
                                                            <!-- Heroicon name: outline/collection -->
                                                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Manajerial</h3>
                                                    <p class="mt-5 text-base text-gray-500"> Pengetahuan dan sikap yang dapat dikembangkan untuk memimpin dan mengelola unit organisasi. </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pt-6">
                                            <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                                <div class="-mt-6">
                                                    <div>
                                                        <span class="inline-flex items-center justify-center p-3 bg-amber-500 rounded-md shadow-lg">
                                                            <!-- Heroicon name: outline/cog -->
                                                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Kemampuan Teknis</h3>
                                                    <p class="mt-5 text-base text-gray-500"> Pengetahuan dan sikap yang dapat dikembangkan yang spesifik berkaitan dengan bidang teknis jabatan. </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pt-6">
                                            <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                                <div class="-mt-6">
                                                    <div>
                                                        <span class="inline-flex items-center justify-center p-3 bg-amber-500 rounded-md shadow-lg">
                                                            <!-- Heroicon name: outline/share -->
                                                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Sosio Kultural</h3>
                                                    <p class="mt-5 text-base text-gray-500"> Kemampuan dalam mempromosikan sikap toleransi, keterbukaan, peka terhadap perbedaan individu/kelompok masyarakat. </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="pt-6"><div class="flow-root bg-gray-50 rounded-lg px-6 pb-8"><div class="-mt-6"><div><span class="inline-flex items-center justify-center p-3 bg-indigo-500 rounded-md shadow-lg"><svg class="h-6 w-6 text-white"
																															xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg></span></div><h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Skolastik</h3><p class="mt-5 text-base text-gray-500">
                          Bertujuan untuk mengetahui bakat dan kemampuan seseorang di bidang kemampuan.
                        </p></div></div></div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ section -->
                        <!-- This example requires Tailwind CSS v2.0+ -->
                        <!-- <div id="faq" class="bg-gray-50"><div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8"><div class="max-w-3xl mx-auto divide-y-2 divide-gray-200"><h2 class="text-center text-3xl font-extrabold text-gray-900 sm:text-4xl">
                  Pertanyaan Umum
                </h2><dl class="mt-6 space-y-6 divide-y divide-gray-200"><div class="pt-6"><dt class="text-lg"><button onclick="toggleFaq('1')" type="button" class="text-left w-full flex justify-between items-start text-gray-400" aria-controls="faq-0" aria-expanded="false"><span class="font-medium text-gray-900">
                          What&#039;s the best thing about Switzerland?
                        </span><span class="ml-6 h-7 flex items-center"><svg id="icon-faq-1" class="h-6 w-6 transform transition"
																											xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg></span></button></dt><dd class="hidden mt-2 pr-12" id="faq-1"><p class="text-base text-gray-500">
                        I don&#039;t know, but the flag is a big plus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cupiditate laboriosam fugiat.
                      </p></dd></div></dl><dl class="mt-6 space-y-6 divide-y divide-gray-200"><div class="pt-6"><dt class="text-lg"><button onclick="toggleFaq('2')" type="button" class="text-left w-full flex justify-between items-start text-gray-400" aria-controls="faq-0" aria-expanded="false"><span class="font-medium text-gray-900">
                          What&#039;s the best thing about Switzerland?
                        </span><span class="ml-6 h-7 flex items-center"><svg id="icon-faq-2" class="h-6 w-6 transform transition"
																											xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg></span></button></dt><dd class="hidden mt-2 pr-12" id="faq-2"><p class="text-base text-gray-500">
                        I don&#039;t know, but the flag is a big plus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cupiditate laboriosam fugiat.
                      </p></dd></div></dl><dl class="mt-6 space-y-6 divide-y divide-gray-200"><div class="pt-6"><dt class="text-lg"><button onclick="toggleFaq('3')" type="button" class="text-left w-full flex justify-between items-start text-gray-400" aria-controls="faq-0" aria-expanded="false"><span class="font-medium text-gray-900">
                          What&#039;s the best thing about Switzerland?
                        </span><span class="ml-6 h-7 flex items-center"><svg id="icon-faq-3" class="h-6 w-6 transform transition"
																											xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg></span></button></dt><dd class="hidden mt-2 pr-12" id="faq-3"><p class="text-base text-gray-500">
                        I don&#039;t know, but the flag is a big plus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cupiditate laboriosam fugiat.
                      </p></dd></div></dl></div></div></div> -->
                        <!-- Partnership -->
                        <!-- This example requires Tailwind CSS v2.0+ -->
                        <div class="bg-white my-16 hidden">
                            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
                                <h2 class="text-center text-3xl font-extrabold text-gray-900 sm:text-4xl flex justify-center items-center"> Partnership <img class="w-32 ml-3" src="{{ asset('assets/frontend/image/logo.png') }}" alt="">
                                </h2>
                                <div class="flex justify-center mt-8">
                                    <div class="py-8 px-32 bg-gray-50">
                                        <img class="w-48" src="https://ayopppk.com/assets/logo/ayocpns_brand_no_white.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- CTA -->
                        <!-- This example requires Tailwind CSS v2.0+ -->
                        <!-- This example requires Tailwind CSS v2.0+ -->
                        <div class="relative bg-gray-800">
                            <div class="h-56 bg-indigo-600 sm:h-72 md:absolute md:left-0 md:h-full md:w-1/2">
                                <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1525130413817-d45c1d127c42?ixlib=rb-1.2.1&ixqx=dQd5ajwMMT&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1920&q=60&blend=6366F1&sat=-100&blend-mode=multiply" alt="">
                            </div>
                            <div class="relative max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
                                <div class="md:ml-auto md:w-1/2 md:pl-10">
                                    <h2 class="text-base font-semibold uppercase tracking-wider text-gray-300">
                                        <!-- #MulaiHariIni -->
                                    </h2>
                                    <p class="mt-2 text-white text-3xl font-extrabold tracking-tight sm:text-4xl"> Mulai Sekarang! </p>
                                    <p class="mt-3 text-lg text-gray-300"> Waktu terbaik untuk belajar adalah kemarin, waktu terbaik kedua adalah hari ini. Yuk #MulaiHariIni </p>
                                    <div class="mt-8">
                                        <div class="inline-flex rounded-md shadow">
                                            <a href="{{ route('register') }}" class="umami--click--cta-register-button inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-gray-900 bg-white hover:bg-gray-50"> Daftar
                                                <!-- Heroicon name: solid/external-link -->
                                                <svg class="-mr-1 ml-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                                                    <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
            <footer class="bg-gray-50 dark:bg-gray-900 overflow-hidden">
                <div>
                    <div class="mx-auto max-w-7xl py-12 px-4 md:px-10 lg:pb-6 lg:pt-6 lg:px-8">
                        <div class="py-10 sm:py-[60px]">
                            <div class="grid sm:grid-cols-2 grid-cols-1 gap-[30px]">
                                <div class="">
                                    <p class=" text-gray-900 font-semibold text-base sm:text-lg uppercase mb-4"> PT AYO KREASI BERSAMA </p>
                                    <div class="mt-2 flex flex-col gap-4">
                                        <div class="flex flex-col xl:flex-row space-y-5 xl:space-y-0 xl:space-x-10">
                                            <p class="text-gray-700 font-sm sm:text-base font-medium flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 -ml-1 mr-1 stroke-2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                                </svg>
                                                <span> Pesona Mutiara Tidar AL-19, Karangwidoro, Kec. Dau, Kabupaten Malang, Jawa Timur 65151 </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex mt-4 sm:mt-0 sm:justify-end space-x-10 sm:space-x-20">
                                    <div>
                                        <div class="flex flex-col xl:flex-row space-y-5 xl:space-y-0 xl:space-x-10">
                                            <p class="text-gray-700 font-sm sm:text-base font-medium flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                                </svg> &nbsp; <span>
                                                    maps.abhy25@gmail.com
                                                </span>
                                            </p>
                                            <p class="text-gray-700 font-sm sm:text-base font-medium flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                                </svg> &nbsp; <span> +62 852-4056-4750 </span>
                                            </p>
                                        </div>
                                        <div class="flex sm:justify-end">
                                            <ul class="list-none mt-4">
                                                <li class="inline-flex space-x-5">
                                                    <a href="https://www.facebook.com/AYOCPNS/" class="text-gray-700 hover:text-gray-900" target="_blank">
                                                        <span class="sr-only">Facebook</span>
                                                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                    <a href="https://www.instagram.com/ayopppk" class="text-gray-700 hover:text-gray-900" target="_blank">
                                                        <span class="sr-only">Instagram</span>
                                                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                    <a href="https://twitter.com/ayocpns" class="text-gray-700 hover:text-gray-900" target="_blank">
                                                        <span class="sr-only">Twitter</span>
                                                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                                        </svg>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-0 flex items-center justify-center">
                            <p class="mt-2 text-sm sm:text-base text-gray-900 md:mt-0 md:text-right text-center"> &copy; {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved. </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
        <script>
            const mobileNavCloseBtn = document.querySelector('#mobileNavCloseBtn');
            mobileNavCloseBtn.addEventListener('click', toggleMobileNav);
            const mobileNavExpandBtn = document.querySelector('#mobileNavExpandBtn');
            mobileNavExpandBtn.addEventListener('click', toggleMobileNav);

            function toggleMobileNav() {
                var element = document.getElementById("mobileNav");
                element.classList.toggle("hidden");
            }

            function toggleFaq(id) {
                var faqContent = document.getElementById('faq-' + id);
                var faqIcon = document.getElementById('icon-faq-' + id);
                faqContent.classList.toggle("hidden");
                faqIcon.classList.toggle("rotate-180");
            }
        </script>
    </body>
</html>