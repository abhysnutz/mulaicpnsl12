<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Belajar dan Latihan Soal Tryout CPNS</title>

    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/frontend/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/frontend/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/frontend/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/frontend/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('assets/frontend/favicon/safari-pinned-tab.svg') }}" color="#f59e0b">
    <meta name="msapplication-TileColor" content="#f59e0b">
    <meta name="theme-color" content="#ffffff">

    <meta name="keywords" content="cpns, bimbel cpns, tryout cpns, soal cpns, mulai cpns, info cpns, jadwal cpns, soal pembahasan cpns, materi cpns, soal manajerial, soal sosio kultural, soal teknis, soal skolastik, tryout cat">
    <meta name="description" content="{{ config('app.name') }} merupakan website belajar online untuk persiapan seleksi CPNS. Belajar secara mudah dan praktis dengan beragam latihan soal dan tryout CAT CPNS.">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:title" content="{{ config('app.name') }} - Belajar, Tryout dan Latihan Soal CPNS">
    <meta property="og:description" content="{{ config('app.name') }} merupakan website belajar online untuk persiapan seleksi CPNS. Belajar secara mudah dan praktis dengan beragam latihan soal dan tryout CAT CPNS.">
    <meta property="og:type" content="website">
</head>

<body>
    <div class="bg-white">
        <main>
            <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>