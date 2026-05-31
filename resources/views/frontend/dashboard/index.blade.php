@extends('frontend.layout')
@section('content')

<div class="pt-4 pb-20 sm:pt-6 sm:pb-6" style="background-color:#f9fafb; min-height:100vh;">
    <div class="mx-auto px-4 sm:px-6 md:px-5">
        <div class="bg-white px-5 pt-5 pb-8 rounded-2xl shadow-sm border border-gray-100">

            <!-- Kartu sambutan -->
            <div class="max-w-4xl mx-auto rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-amber-500 font-bold text-white p-4 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="uppercase">Halo, {{ Auth::user()?->name }}</span>
                </div>

                <div class="p-5 text-gray-700">
                    <!-- Badge status -->
                    @if (Auth::user()?->subscription_status == 'free')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold" style="background-color:#f3f4f6; color:#4b5563;">
                            <span class="w-2 h-2 rounded-full mr-1.5" style="background-color:#9ca3af;"></span>
                            Status: FREE
                        </span>
                        <p class="mt-3">Status Anda saat ini masih <span class="font-bold">Free</span>.</p>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold text-white" style="background-color:#d97706;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5 mr-1" style="width:14px;height:14px;">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.364 1.118l1.287 3.957c.3.922-.755 1.688-1.54 1.118l-3.366-2.446a1 1 0 00-1.175 0l-3.366 2.446c-.784.57-1.838-.196-1.539-1.118l1.286-3.957a1 1 0 00-.363-1.118L2.072 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z"></path>
                            </svg>
                            Status: PREMIUM
                        </span>
                        <p class="mt-3">Status Anda saat ini adalah user <span class="font-bold">Premium</span> sampai tanggal <span class="font-bold">{{ \Carbon\Carbon::parse(Auth::user()?->subscription?->end_date)->translatedFormat('d F Y') }}</span>.</p>
                    @endif

                    <p class="mt-1">Selamat berlatih di <span class="font-bold">{{ config('app.name') }}</span>.</p>
                    <p class="mt-2 text-gray-600">SKD CPNS sudah semakin dekat, yuk akses latihan soal beserta pembahasan dengan cara upgrade statusmu, dapatkan fasilitas yang lebih lengkap.</p>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('petunjuk_upgrade') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-sm hover:shadow hover:bg-blue-600 transition-all text-sm font-medium">SILAHKAN BACA DI SINI</a>
                        <a href="https://api.whatsapp.com/send/?phone={{ config('services.admin_whatsapp') }}&text={{ rawurlencode('Halo kak, saya mau tanya tentang ') }}&app_absent=0" target="_blank" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-sm hover:shadow flex items-center hover:bg-green-600 transition-all text-sm font-medium">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.472 14.382c-.291-.146-1.719-.85-1.985-.947-.267-.098-.462-.146-.658.146-.197.291-.756.947-.927 1.144-.171.197-.341.22-.633.073-.291-.146-1.233-.455-2.35-1.452-.869-.774-1.457-1.732-1.63-2.023-.171-.292-.019-.449.127-.595.13-.13.291-.341.438-.512.146-.171.195-.293.292-.488.098-.195.049-.366-.024-.512-.073-.146-.658-1.592-.901-2.176-.237-.567-.48-.489-.658-.5-.171-.007-.366-.009-.56-.009s-.512.073-.78.366c-.268.293-1.024 1.002-1.024 2.439s1.048 2.829 1.194 3.025c.146.195 2.056 3.142 4.985 4.412.696.3 1.24.479 1.663.613.7.222 1.337.191 1.84.116.56-.084 1.719-.703 1.963-1.382.244-.68.244-1.26.171-1.382-.073-.122-.267-.195-.56-.341zM12.003 2c-5.524 0-10 4.477-10 10 0 1.768.466 3.487 1.356 4.996L2 22l5.155-1.34c1.461.799 3.081 1.217 4.848 1.217 5.523 0 10-4.477 10-10s-4.477-10-10-10zm0 18.1c-1.59 0-3.15-.42-4.51-1.2l-.32-.19-3.06.8.81-2.98-.21-.31c-.83-1.29-1.27-2.78-1.27-4.32 0-4.41 3.59-8 8-8s8 3.59 8 8-3.59 8-8 8z"/>
                            </svg>
                            CHAT ADMIN
                        </a>
                        <a href="{{ route('payment.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-sm hover:shadow hover:bg-blue-600 transition-all text-sm font-medium">
                            @if (Auth::user()?->subscription_status == 'free') UPGRADE PREMIUM @else PERPANJANG PREMIUM @endif
                        </a>
                    </div>
                </div>
            </div>

            <!-- Kartu passing grade -->
            <div class="mt-5 max-w-4xl mx-auto rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-amber-500 font-bold text-white p-4 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="uppercase">Passing Grade</span>
                </div>

                <div class="p-5 text-gray-700">
                    <p class="text-sm">Berdasarkan <a href="#" class="text-blue-500 underline">Keputusan Menpan RB Nomor 321 Tahun 2024</a>, jumlah soal SKD adalah sebanyak <strong>110</strong> soal. Passing Grade untuk masing-masing jenis tes SKD adalah sebagai berikut:</p>

                    <!-- Ringkasan PG TWK/TIU/TKP -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-4">
                        <div class="p-4 rounded-xl border border-gray-100" style="background-color:#fffbeb;">
                            <p class="text-xs font-bold uppercase tracking-wide" style="color:#d97706;">TWK</p>
                            <p class="text-xs text-gray-500">Wawasan Kebangsaan</p>
                            <p class="mt-2 text-sm text-gray-600">30 soal · maks <strong>150</strong></p>
                            <p class="text-lg font-bold text-gray-900">PG 65</p>
                        </div>
                        <div class="p-4 rounded-xl border border-gray-100" style="background-color:#fffbeb;">
                            <p class="text-xs font-bold uppercase tracking-wide" style="color:#d97706;">TIU</p>
                            <p class="text-xs text-gray-500">Intelegensia Umum</p>
                            <p class="mt-2 text-sm text-gray-600">35 soal · maks <strong>175</strong></p>
                            <p class="text-lg font-bold text-gray-900">PG 80</p>
                        </div>
                        <div class="p-4 rounded-xl border border-gray-100" style="background-color:#fffbeb;">
                            <p class="text-xs font-bold uppercase tracking-wide" style="color:#d97706;">TKP</p>
                            <p class="text-xs text-gray-500">Karakteristik Pribadi</p>
                            <p class="mt-2 text-sm text-gray-600">45 soal · maks <strong>225</strong></p>
                            <p class="text-lg font-bold text-gray-900">PG 166</p>
                        </div>
                    </div>

                    <p class="text-xs text-gray-500 mt-3">*Berlaku untuk Kebutuhan Umum &amp; Kebutuhan Khusus Putra/Putri Kalimantan.</p>

                    <!-- Ketentuan khusus -->
                    <div class="mt-4 space-y-3">
                        <div class="p-4 rounded-xl border border-gray-100" style="background-color:#fafafa;">
                            <p class="text-sm font-semibold text-gray-800">Kebutuhan Khusus — Putra/Putri Lulusan Terbaik</p>
                            <ul class="list-disc list-inside text-sm text-gray-600 mt-1 space-y-0.5">
                                <li>Nilai kumulatif SKD paling rendah <strong>311</strong>.</li>
                                <li>Nilai TIU paling rendah <strong>85</strong>.</li>
                            </ul>
                        </div>
                        <div class="p-4 rounded-xl border border-gray-100" style="background-color:#fafafa;">
                            <p class="text-sm font-semibold text-gray-800">Kebutuhan Khusus — Penyandang Disabilitas &amp; Putra/Putri Papua</p>
                            <ul class="list-disc list-inside text-sm text-gray-600 mt-1 space-y-0.5">
                                <li>Nilai kumulatif SKD paling rendah <strong>286</strong>.</li>
                                <li>Nilai TIU paling rendah <strong>60</strong>.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection