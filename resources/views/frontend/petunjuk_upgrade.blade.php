@extends('frontend.layout')
@section('content')
<div class="pt-4 pb-20 sm:pt-6 sm:pb-6">
    <div class="mx-auto px-4 sm:px-6 md:px-5">
        <div class="bg-white px-5 pt-5 pb-8 rounded-lg">
            @include('frontend.breadcrumb', ['content' => 'Petunjuk Upgrade'])
            
            <div class="max-w-4xl mx-auto p-6 sm:p-8 bg-amber-50 rounded-xl shadow-lg border border-gray-100 space-y-10">

                <!-- Section 1: Informasi Awal -->
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-amber-600 mb-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8z" />
                        </svg>
                        Informasi Penting Sebelum Upgrade
                    </h2>
                    <p class="text-gray-600 text-sm sm:text-base mb-4">
                        Berikut beberapa hal yang perlu kamu ketahui sebelum melakukan upgrade ke <strong>Premium</strong>.
                    </p>

                    <ul class="space-y-3 text-gray-700 text-sm sm:text-base">
                        <li class="flex items-start gap-3">
                            <span class="w-7 h-7 flex items-center justify-center bg-amber-500 text-white font-bold rounded-full">1</span>
                            <span>Jika status Anda masih <strong>"FREE"</strong>, maka Anda belum memiliki akses ke <strong>Tryout Premium</strong>.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-7 h-7 flex items-center justify-center bg-amber-500 text-white font-bold rounded-full">2</span>
                            <span>Anda tetap bisa mengikuti <strong>Latihan Tryout</strong> yang statusnya <strong>"FREE"</strong> aja.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-7 h-7 flex items-center justify-center bg-amber-500 text-white font-bold rounded-full">3</span>
                            <span>Tryout Free bisa diulang, namun belum tersedia pembahasan soal.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-7 h-7 flex items-center justify-center bg-amber-500 text-white font-bold rounded-full">4</span>
                            <span>Untuk akses soal & pembahasan lengkap, silakan upgrade menjadi <span class="font-semibold text-blue-600">PESERTA PREMIUM</span>.</span>
                        </li>
                    </ul>
                </div>

                <!-- Section 2: Cara Menjadi Premium -->
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-amber-600 mb-2">
                        Cara Menjadi Peserta Premium 🪙
                    </h2>
                    <p class="text-gray-700 leading-relaxed text-sm sm:text-base text-justify">
                        Dengan membayar <span class="font-bold text-emerald-700">Rp 50.000</span>, Anda turut berkontribusi untuk membantu biaya operasional platform, server hosting, dan pengembangan sistem. 
                        Dukungan Anda sangat berarti bagi kami untuk terus menyediakan soal dan pembahasan yang berkualitas untuk semua peserta.
                    </p>
                    <p class="mt-4 text-gray-700 text-sm sm:text-base">Keanggotaan berlaku <strong>1 tahun</strong> sejak tanggal upgrade.</p>
                </div>

                <!-- Section 3: Fasilitas Premium -->
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-amber-600 mb-2">
                        Fasilitas Peserta Premium 🏆
                    </h2>
                    <ul class="space-y-3 text-gray-700 text-sm sm:text-base">
                        <li class="flex items-start gap-3">
                            <span class="w-7 h-7 flex items-center justify-center bg-amber-500 text-white font-bold rounded-full">1</span>
                            <span>Tryout dapat diulang dan dikerjakan kapan saja.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-7 h-7 flex items-center justify-center bg-amber-500 text-white font-bold rounded-full">2</span>
                            <span>Mendapatkan <strong>Paket Soal dan Pembahasan</strong> Tryout & Mini Tryout (TWK, TIU, TKP).</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-7 h-7 flex items-center justify-center bg-amber-500 text-white font-bold rounded-full">3</span>
                            <span>Akses <strong>Modul Ebook</strong> materi SKD & TPA secara offline.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-7 h-7 flex items-center justify-center bg-amber-500 text-white font-bold rounded-full">4</span>
                            <span>Fasilitas berlaku selama <strong>1 tahun</strong>.</span>
                        </li>
                    </ul>

                    <div class="mt-6 text-center space-y-1">
                        <p class="font-semibold text-gray-800">💪 Semangat belajar dan berlatih wujudkan harapan menjadi ASN</p>
                        <p class="font-medium text-gray-700">Kami membantu… Anda membantu… Kita saling membantu 🤝</p>
                    </div>
                </div>

                <!-- Section 4: Cara Upgrade -->
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-amber-600 mb-2">
                        Langkah Upgrade Premium ⚡
                    </h2>
                    <ul class="space-y-3 text-gray-700 text-sm sm:text-base">
                        <li class="flex items-start gap-3">
                            <span class="w-7 h-7 flex items-center justify-center bg-amber-500 text-white font-bold rounded-full">1</span>
                            <span>Transfer <span class="font-bold text-emerald-700">Rp 50.000</span> melalui sistem transfer/top up.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-7 h-7 flex items-center justify-center bg-amber-500 text-white font-bold rounded-full">2</span>
                            <span>Metode: BNI, BCA, OVO, DANA, LINKAJA.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-7 h-7 flex items-center justify-center bg-amber-500 text-white font-bold rounded-full">3</span>
                            <span>Lihat nomor rekening di halaman ini.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-7 h-7 flex items-center justify-center bg-amber-500 text-white font-bold rounded-full">4</span>
                            <span>Untuk metode lain, silakan <strong>Chat Mimin</strong>.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-7 h-7 flex items-center justify-center bg-amber-500 text-white font-bold rounded-full">5</span>
                            <span>Klik tombol di bawah untuk melanjutkan proses pembayaran.</span>
                        </li>
                    </ul>

                    <div class="mt-8 flex justify-center">
                        <a href="{{ route('payment.index') }}" 
                        class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white text-sm sm:text-base font-semibold px-6 py-3 rounded-lg shadow-md transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            @if (Auth::user()?->subscription_status == 'free') 
                                UPGRADE SEKARANG 
                            @else 
                                PERPANJANG PREMIUM 
                            @endif
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection