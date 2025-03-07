@extends('frontend.layout')
@section('content')

<div class="pt-4 pb-20 sm:pt-6 sm:pb-6">
    <div class="mx-auto px-4 sm:px-6 md:px-5">
        <div class="bg-white px-5 pt-5 pb-8 rounded-lg">
                
            <div class="max-w-4xl mx-auto rounded-lg shadow-lg">
                <!-- Header -->
                <div class="bg-indigo-500 font-bold text-white p-4 rounded-t-lg flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="uppercase">HALO.., {{ Auth::user()?->name }}</span>
                </div>

                <!-- Content -->
                <div class="p-4 text-gray-700">
                    @if (Auth::user()?->subscription_status == 'free')
                        <p>Status Anda saat ini masih <span class="font-bold capitalize">Free</span>,</p>
                    @else
                        <p>Status Anda saat ini adalah user <span class="font-bold capitalize">Premium</span> sampai tanggal <span class="font-bold">{{ \Carbon\Carbon::parse(Auth::user()?->subscription?->end_date)->translatedFormat('d F Y') }}</span>,</p>
                    @endif
                    <p>Selamat berlatih di <span class="font-bold">{{ env('APP_NAME') }}</span>.</p>
                    <p class="mt-2">SKD CPNS sudah semakin dekat, yuk akses latihan soal beserta pembahasan dengan cara upgrade statusmu, dapatkan fasilitas yang lebih lengkap.</p>

                    <!-- Buttons -->
                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('petunjuk_upgrade') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md shadow hover:bg-blue-600 transition">SILAHKAN BACA DI SINI</a>
                        <a href="#" class="bg-green-500 text-white px-4 py-2 rounded-md shadow flex items-center hover:bg-green-600 transition">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.472 14.382c-.291-.146-1.719-.85-1.985-.947-.267-.098-.462-.146-.658.146-.197.291-.756.947-.927 1.144-.171.197-.341.22-.633.073-.291-.146-1.233-.455-2.35-1.452-.869-.774-1.457-1.732-1.63-2.023-.171-.292-.019-.449.127-.595.13-.13.291-.341.438-.512.146-.171.195-.293.292-.488.098-.195.049-.366-.024-.512-.073-.146-.658-1.592-.901-2.176-.237-.567-.48-.489-.658-.5-.171-.007-.366-.009-.56-.009s-.512.073-.78.366c-.268.293-1.024 1.002-1.024 2.439s1.048 2.829 1.194 3.025c.146.195 2.056 3.142 4.985 4.412.696.3 1.24.479 1.663.613.7.222 1.337.191 1.84.116.56-.084 1.719-.703 1.963-1.382.244-.68.244-1.26.171-1.382-.073-.122-.267-.195-.56-.341zM12.003 2c-5.524 0-10 4.477-10 10 0 1.768.466 3.487 1.356 4.996L2 22l5.155-1.34c1.461.799 3.081 1.217 4.848 1.217 5.523 0 10-4.477 10-10s-4.477-10-10-10zm0 18.1c-1.59 0-3.15-.42-4.51-1.2l-.32-.19-3.06.8.81-2.98-.21-.31c-.83-1.29-1.27-2.78-1.27-4.32 0-4.41 3.59-8 8-8s8 3.59 8 8-3.59 8-8 8z"/>
                            </svg>
                            CHAT ADMIN
                        </a>
                        <a href="{{ route('payment.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md shadow hover:bg-blue-600 transition">
                            @if (Auth::user()?->subscription_status == 'free') UPGRADE PREMIUM @else PERPANJANG PREMIUM @endif
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-5 max-w-4xl mx-auto rounded-lg shadow-lg">
                <!-- Header -->
                <div class="bg-indigo-500 font-bold text-white p-4 rounded-t-lg flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="uppercase">PASSING GRADE</span>
                </div>

                <!-- Content -->
                <div class="p-4 text-gray-700">
                    <p>Berdasarkan <a href="#" class="text-blue-500 underline">Keputusan Menpan RB Nomor 321 Tahun 2024</a>, jumlah soal SKD adalah sebanyak <strong>110</strong> soal. Passing Grade untuk masing-masing jenis tes SKD adalah sebagai berikut:</p>

                    <!-- Nilai Ambang Batas -->
                    <ol class="list-decimal list-inside mt-3">
                        <li>
                            <strong>Nilai Ambang Batas Kebutuhan Umum dan Kebutuhan Khusus untuk Putra/Putri Kalimantan</strong>
                            <ul class="list-disc list-inside ml-4 mt-2">
                                <li><strong>TWK (Tes Wawasan Kebangsaan):</strong>
                                    <ul class="list-inside ml-5 text-sm">
                                        <li>Jumlah Soal: 30</li>
                                        <li>Nilai Maksimum: <strong>150</strong></li>
                                        <li>Nilai Minimum: <strong>65</strong></li>
                                    </ul>
                                </li>
                                <li class="mt-2"><strong>TIU (Tes Intelegensia Umum):</strong>
                                    <ul class="list-inside ml-5 text-sm">
                                        <li>Jumlah Soal: 35</li>
                                        <li>Nilai Maksimum: <strong>175</strong></li>
                                        <li>Nilai Minimum: <strong>80</strong></li>
                                    </ul>
                                </li>
                                <li class="mt-2"><strong>TKP (Tes Karakteristik Pribadi):</strong>
                                    <ul class="list-inside ml-5 text-sm">
                                        <li>Jumlah Soal: 45</li>
                                        <li>Nilai Maksimum: <strong>225</strong></li>
                                        <li>Nilai Minimum: <strong>166</strong></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="mt-3">
                            <strong>Nilai Ambang Batas Kebutuhan Khusus untuk Putra/Putri Lulusan Terbaik</strong>
                            <ul class="list-disc list-inside ml-4 text-sm">
                                <li>Nilai kumulatif SKD yang harus dicapai paling rendah adalah <strong>311</strong> (tiga ratus sebelas).</li>
                                <li>Nilai TIU yang harus dicapai paling rendah adalah <strong>85</strong> (delapan puluh lima).</li>
                            </ul>
                        </li>

                        <li class="mt-3">
                            <strong>Nilai Ambang Batas Kebutuhan Khusus untuk Penyandang Disabilitas dan Putra/Putri Papua</strong>
                            <ul class="list-disc list-inside ml-4 text-sm">
                                <li>Nilai kumulatif SKD yang harus dicapai paling rendah adalah <strong>286</strong> (dua ratus delapan puluh enam).</li>
                                <li>Nilai TIU yang harus dicapai paling rendah adalah <strong>60</strong> (enam puluh).</li>
                            </ul>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection