<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Tidak Ditemukan | MULAICPNS</title>
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
</head>

<body>
    <!-- component -->
    <div class="min-w-screen min-h-screen bg-amber-100 flex items-center p-5 lg:p-20 overflow-hidden relative">
        <div class="flex-1 min-h-full min-w-full rounded-3xl bg-white shadow-xl p-10 lg:p-20 text-gray-800 relative md:flex items-center text-center md:text-left">
            <div class="w-full md:w-1/2">
                <div class="mb-10 lg:mb-20">
                    <img
                        class="h-36 w-auto"
                        src="{{ asset('assets/frontend/image/logo.png') }}"
                        alt="Workflow"
                    />
                </div>
                <div class="mb-10 md:mb-20 text-gray-600 font-light">
                    <h1 class="font-black uppercase text-3xl lg:text-5xl text-gray-500 mb-10">Whoops.. <span class="text-red-400 ml-2"> 404!</span></h1>
                    <p class="font-medium">Mohon maaf halaman yang Anda cari tidak ditemukan.</p>
                </div>
                <div class="mb-20 md:mb-0">
                    <a href="{{ route('dashboard.index') }}" class="text-lg outline-none font-medium focus:outline-none transform transition-all hover:-translate-y-0.5 text-red-400 hover:text-red-600 flex items-center md:justify-start justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                        </svg>
                        Kembali</a>
                </div>
            </div>
            <div class="w-full md:w-1/2 text-center">
                <img src="{{ asset('assets/frontend/image/undraw_404.svg') }}" class="w-full" alt="Halaman Tidak Ditemukan">
            </div>
        </div>
        <div class="w-64 md:w-96 h-96 md:h-full bg-amber-200 bg-opacity-30 absolute -top-64 md:-top-96 right-20 md:right-32 rounded-full pointer-events-none -rotate-45 transform"></div>
        <div class="w-96 h-full bg-amber-200 bg-opacity-20 absolute -bottom-96 right-64 rounded-full pointer-events-none -rotate-45 transform"></div>
    </div>
</body>

</html>
