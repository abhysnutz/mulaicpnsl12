@extends('frontend.layout')
@section('content')
<div class="pt-4 pb-20 sm:pt-6 sm:pb-6">
    <div class="mx-auto px-4 sm:px-6 md:px-5">
        <div class="bg-white px-5 pt-5 pb-8 rounded-lg">
            @include('frontend.breadcrumb', ['content' => 'Petunjuk Upgrade'])
            
            <div class="max-w-100 mx-auto p-4 sm:p-6 bg-white rounded-lg shadow-md border border-gray-200">
                <h2 class="text-base sm:text-lg font-semibold text-gray-800">
                    Sebelum melangkah lebih lanjut, berikut beberapa informasi yang perlu diketahui:
                </h2>
            
                <ul class="mt-4 space-y-3 text-gray-700 text-sm sm:text-base">
                    <li class="flex items-start space-x-3">
                        <span class="flex justify-center w-7 h-7 font-bold rounded-full shrink-0 self-start">
                            1
                        </span>
                        <span class="flex-1">
                            Jika status Anda masih peserta <span class="font-semibold">"FREE"</span>, maka Anda belum memiliki akses untuk mengikuti <span class="font-semibold">Tryout Premium</span>.
                        </span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="flex justify-center w-7 h-7 font-bold rounded-full shrink-0 self-start">
                            2
                        </span>
                        <span class="flex-1">
                            Anda tetap bisa mengikuti <span class="font-semibold">Latihan Tryout</span> yang statusnya <span class="font-semibold">"FREE"</span> aja.
                        </span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="flex justify-center w-7 h-7 font-bold rounded-full shrink-0 self-start">
                            3
                        </span>
                        <span class="flex-1">
                            Tryout Free bisa diulang, namun mohon maaf belum dapat pembahasannya ya.
                        </span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="flex justify-center w-7 h-7 font-bold rounded-full shrink-0 self-start">
                            4
                        </span>
                        <span class="flex-1">
                            Untuk dapat melihat/mendownload latihan soal + pembahasannya maka Anda kami sarankan upgrade keanggotaan menjadi peserta <span class="font-semibold text-blue-600">PREMIUM</span> terlebih dahulu.
                        </span>
                    </li>
                </ul>

                <h2 class="text-base sm:text-lg font-semibold text-gray-800 mt-5">
                    Bagaimana cara menjadi Peserta Premium ?
                </h2>

                <p class="mt-3 text-gray-700 text-sm sm:text-base" style="text-align: justify">
                    Dengan membayar Rp50.000, berarti Anda telah turut memberikan kontribusi membantu kami dalam biaya operasional, biaya sewa hosting maupun sewa domain website.<br />
                    Karena untuk mengelola itu semua kami juga membutuhkan biaya serta dukungan dari berbagai pihak termasuk dari Anda. Sehingga kami juga semangat dalam mencari referensi soal dari internet untuk dibagikan kepada Anda dan peserta lainnya.
                </p>

                <p class="mt-10 text-gray-700 text-sm sm:text-base">Harapan kami cara dan nilai tersebut diatas tidak memberatkan Anda. Dan tidak ada paksaan untuk itu.</p>

                <p class="mt-3 text-gray-700 text-sm sm:text-base">Keanggotaan hanya berlaku <strong>1 tahun sejak tanggal upgrade</strong>. (Misal upgrade tanggal 1 Mei 2025 maka berakhir tanggal 1 Mei 2026)</p>

                <h2 class="mt-10 text-base sm:text-lg font-semibold text-gray-800">
                    Tentang Fasilitas Pengguna / Peserta Premium
                </h2>

                <ul class="mt-4 space-y-3 text-gray-700 text-sm sm:text-base">
                    <li class="flex items-start space-x-3">
                        <span class="flex justify-center w-7 h-7 font-bold rounded-full shrink-0 self-start">
                            1
                        </span>
                        <span class="flex-1">
                            Tryout dapat diulang dan dilakukan kapan saja.
                        </span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="flex justify-center w-7 h-7 font-bold rounded-full shrink-0 self-start">
                            2
                        </span>
                        <span class="flex-1">
                            Mendapatkan Paket Soal dan Pembahasan Tryout dan Mini Tryout per jenis TKD.
                        </span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="flex justify-center w-7 h-7 font-bold rounded-full shrink-0 self-start">
                            3
                        </span>
                        <span class="flex-1">
                            Kumpulan Modul Ebook Soal SKD, TPA maupn SKD untuk menambah referensi bahan belajar secara offline.
                        </span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="flex justify-center w-7 h-7 font-bold rounded-full shrink-0 self-start">
                            4
                        </span>
                        <span class="flex-1">
                            Fasilitas berlaku <span class="font-semibold">1 tahun sejak tanggal upgrade.</span>
                        </span>
                    </li>
                </ul>

                <p class="mt-10"><strong>Semangat belajar dan berlatih wujudkan harapan menjadi ASN</strong></p>
                <p class="mt-3"><strong>Kami membantu...</strong></p>
                <p class="mt-3"><strong>Anda membantu...</strong></p>
                <p class="mt-3"><strong>Kita saling  membantu...</strong></p>

                <h2 class="mt-10 text-base sm:text-lg font-semibold text-gray-800">
                    Saya ingin upgrade, Bagaimana Caranya
                </h2>
                <ul class="mt-4 space-y-3 text-gray-700 text-sm sm:text-base">
                    <li class="flex items-start space-x-3">
                        <span class="flex justify-center w-7 h-7 font-bold rounded-full shrink-0 self-start">
                            1
                        </span>
                        <span class="flex-1">
                            Membayar Rp. 50.000,- melalui sistem transfer./top up.
                        </span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="flex justify-center w-7 h-7 font-bold rounded-full shrink-0 self-start">
                            2
                        </span>
                        <span class="flex-1">
                            Transfer atau Top Up bisa ke Bank BNI, BCA, OVO, LINKAJA, DANA.
                        </span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="flex justify-center w-7 h-7 font-bold rounded-full shrink-0 self-start">
                            3
                        </span>
                        <span class="flex-1">
                            Nomor Rekening ada dihalaman upgrade.
                        </span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="flex justify-center w-7 h-7 font-bold rounded-full shrink-0 self-start">
                            4
                        </span>
                        <span class="flex-1">
                            Untuk opsi yang lain?  (Silahkan Chat Mimin)
                        </span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="flex justify-center w-7 h-7 font-bold rounded-full shrink-0 self-start">
                            5
                        </span>
                        <span class="flex-1">
                            Silahkan lanjut dan Klik Link dibawah ya....
                        </span>
                    </li>
                </ul>
                <div class="mt-10 flex items-center justify-center">
                    <a href="{{ route('payment.index') }}" class="bg-blue-500 text-white text-sm font-medium px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition-all">
                        @if (Auth::user()?->subscription_status == 'free') UPGRADE SEKARANG @else PERPANJANG PREMIUM @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection