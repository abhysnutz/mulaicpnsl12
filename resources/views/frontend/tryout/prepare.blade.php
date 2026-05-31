@extends('frontend.layout')
@section('content')
<div class="pt-4 pb-20 sm:pt-6 sm:pb-6" style="background-color:#f9fafb; min-height:100vh;">
    <div class="mx-auto px-4 sm:px-6 md:px-5">
        <div class="bg-white px-5 pt-5 pb-8 rounded-2xl shadow-sm border border-gray-100">
            @include('frontend.breadcrumb', ['content' => 'Persiapan'])

            <div class="mt-5">
                <!-- Banner PENTING (aksen kiri) -->
                <div class="flex items-start gap-3 p-4 rounded-xl border border-blue-100"
                     style="background-color:#fffbeb; border-left:4px solid #f59e0b;">
                    <div class="flex-shrink-0 flex items-center justify-center w-9 h-9 rounded-lg"
                         style="background-color:#fef3c7; color:#d97706;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wide" style="color:#d97706;">Penting</p>
                        <p class="text-sm" style="color:#78350f;">Gunakan <span class="font-semibold">Google Chrome</span> versi terbaru dan pastikan koneksi internet stabil sebelum mulai mengerjakan.</p>
                    </div>
                </div>

                <!-- Kartu utama: judul + meta -->
                <div class="mt-6 p-6 sm:p-7 rounded-2xl bg-white border border-gray-100 shadow-sm">
                    <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold text-white"
                          style="background-color:#f59e0b;">LATIHAN SOAL</span>
                    <h1 class="mt-3 text-2xl sm:text-3xl font-bold text-gray-900">{{ $tryout?->title ?? '-' }}</h1>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-5">
                        <div class="p-4 rounded-xl border border-gray-100" style="background-color:#f9fafb;">
                            <div class="flex items-center text-xs font-semibold uppercase tracking-wide" style="color:#6b7280;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-1.5" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Jumlah Soal
                            </div>
                            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $tryout?->questions?->count() ?? 0 }} <span class="text-sm font-medium text-gray-500">Soal</span></p>
                        </div>

                        <div class="p-4 rounded-xl border border-gray-100" style="background-color:#f9fafb;">
                            <div class="flex items-center text-xs font-semibold uppercase tracking-wide" style="color:#6b7280;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-1.5" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Durasi
                            </div>
                            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $tryout?->duration ?? 100 }} <span class="text-sm font-medium text-gray-500">Menit</span></p>
                        </div>
                    </div>
                </div>

                @php
                    $pg_twk = (int) setting('passing_grade_twk');
                    $pg_tiu = (int) setting('passing_grade_tiu');
                    $pg_tkp = (int) setting('passing_grade_tkp');
                @endphp

                <!-- Passing Grade -->
                <div class="mt-6 p-6 sm:p-7 rounded-2xl bg-white border border-gray-100 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-xl"
                             style="background-color:#fef3c7; color:#d97706;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-base font-bold text-gray-900">Passing Grade</p>
                            <p class="text-sm text-gray-500">Standar kelulusan minimum per kategori</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-5">
                        <div class="p-4 rounded-xl border border-gray-100" style="background-color:#f9fafb;">
                            <p class="text-xs font-bold uppercase tracking-wide" style="color:#d97706;">TWK</p>
                            <p class="text-sm text-gray-600">Tes Wawasan Kebangsaan</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900">{{ $pg_twk }}</p>
                        </div>
                        <div class="p-4 rounded-xl border border-gray-100" style="background-color:#f9fafb;">
                            <p class="text-xs font-bold uppercase tracking-wide" style="color:#d97706;">TIU</p>
                            <p class="text-sm text-gray-600">Tes Intelegensia Umum</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900">{{ $pg_tiu }}</p>
                        </div>
                        <div class="p-4 rounded-xl border border-gray-100" style="background-color:#f9fafb;">
                            <p class="text-xs font-bold uppercase tracking-wide" style="color:#d97706;">TKP</p>
                            <p class="text-sm text-gray-600">Tes Karakteristik Pribadi</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900">{{ $pg_tkp }}</p>
                        </div>
                    </div>
                </div>

                <!-- Footer CTA (gradient inline = anti purge) -->
                <div class="mt-6 p-6 sm:p-7 rounded-2xl text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
                     style="background-image:linear-gradient(135deg, #d97706 0%, #b45309 100%);">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 flex items-center justify-center w-11 h-11 rounded-xl"
                             style="background-color:rgba(255,255,255,0.2);">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide" style="color:rgba(255,255,255,0.75);">Siap Mulai?</p>
                            <p class="text-lg font-bold">Kerjakan dengan tenang &amp; raih skor terbaikmu.</p>
                        </div>
                    </div>
                    <div class="flex gap-3 flex-shrink-0">
                        <a href="{{ route('tryout.index') }}"
                           class="inline-flex justify-center items-center px-5 py-3 rounded-xl font-semibold text-sm transition-all"
                           style="background-color:rgba(255,255,255,0.15); color:#ffffff;">
                            Kembali
                        </a>
                        <button id="btn-prepare" type="button"
                                class="inline-flex justify-center items-center px-5 py-3 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg transition-all"
                                style="background-color:#ffffff; color:#b45309;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Mulai Mengerjakan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal: Perhatian -->
            <div class="fixed z-10 inset-0 overflow-y-auto alert-overflow" style="display: none;">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div aria-hidden="true" class="fixed inset-0 transition-opacity alert-background" style="display: none;">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                    <span aria-hidden="true" class="hidden sm:inline-block sm:align-middle sm:h-screen">​</span>
                    <div role="dialog" aria-modal="true" aria-labelledby="modal-headline" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full alert-content" style="display: none;">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="h-6 w-6 text-yellow-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 id="modal-headline" class="text-lg leading-6 font-semibold text-gray-900">Perhatian Sebelum Mengerjakan</h3>
                                    <ul class="mt-2 text-sm text-gray-600 list-disc pl-4 space-y-1">
                                        <li>Disarankan menggunakan browser Google Chrome versi terbaru supaya website dapat diakses dengan lancar tanpa masalah.</li>
                                        <li>Pastikan koneksi internet stabil saat mengerjakan dan submit jawaban.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <a href="#" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm hover:shadow px-4 py-2 bg-amber-500 text-base font-medium text-white hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:ml-3 sm:w-auto sm:text-sm transition start-exam-btn" data-tryout-id="{{ $tryout->id }}">Kerjakan Sekarang</a>
                            <button id="btn-prepare-cancel" type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">Batal</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal kedua (dibiarkan seperti aslinya) -->
            <div class="fixed z-10 inset-0 overflow-y-auto" style="display: none;">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div aria-hidden="true" class="fixed inset-0 transition-opacity" style="display: none;">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                    <span aria-hidden="true" class="hidden sm:inline-block sm:align-middle sm:h-screen">​</span>
                    <div role="dialog" aria-modal="true" aria-labelledby="modal-headline" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" style="display: none;">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-blue-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path>
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 id="modal-headline" class="text-base sm:text-lg leading-6 font-medium text-gray-900"></h3>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-amber-600 text-base font-medium text-white hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:ml-3 sm:w-auto sm:text-sm transition"> Ya, Lanjut Mengerjakan </button>
                            <button type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"> Tidak </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js-bottom')
    <script>
        $(".start-exam-btn").click(function(e) {
            e.preventDefault();

            let tryout_id = $(this).data("tryout-id");

            $.ajax({
                url: "{{ route('tryout.exam') }}",
                type: "POST",
                data: {
                    tryout_id: tryout_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    console.log(response.data.id);

                    if (response.data.id) {
                        window.location.href = "{{ route('tryout.working', ':id') }}".replace(':id', response.data.id);
                    } else {
                        alert("Gagal memulai ujian. Silakan coba lagi.");
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert("Terjadi kesalahan.");
                }
            });
        });

        $('#btn-prepare').on('click', function(){
            $('.alert-overflow, .alert-background, .alert-content').fadeIn("fast");
        })

        $('#btn-prepare-cancel').on('click', function(){
            $('.alert-overflow, .alert-background, .alert-content').fadeOut("fast");
        })

    </script>
@endpush