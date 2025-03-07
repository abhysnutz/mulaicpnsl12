@extends('frontend.layout')
@section('content')
<div class="pt-4 pb-20 sm:pt-6 sm:pb-6">
    <div class="mx-auto px-4 sm:px-6 md:px-5">
        <div class="bg-white px-5 pt-5 pb-8 rounded-lg">
            @include('frontend.breadcrumb', ['content' => 'Persiapan'])
            <div>
                <!---->
                <div>
                    <div class="mt-5 border-t border-gray-200">
                        <dl class="sm:divide-y sm:divide-gray-200">
                            <div class="py-4 sm:grid sm:grid-cols-4 lg:grid-cols-7 sm:gap-4 border-b">
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 sm:col-span-2 lg:col-span-2">Judul</dt>
                                <dd class="mt-1 text-xs sm:text-sm font-medium text-gray-900 sm:mt-0 sm:col-span-2 lg:col-span-5"> {{ $tryout?->title ?? '-' }}
                                    <!---->
                                </dd>
                            </div>
                            <div class="py-4 sm:grid sm:grid-cols-4 lg:grid-cols-7 sm:gap-4 border-b">
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 sm:col-span-2 lg:col-span-2">Jumlah Soal</dt>
                                <dd class="mt-1 text-xs sm:text-sm font-medium text-gray-900 sm:mt-0 sm:col-span-2 lg:col-span-5">{{ $tryout?->questions?->count() ?? 0 }} Soal</dd>
                            </div>
                            <div class="py-4 sm:grid sm:grid-cols-4 lg:grid-cols-7 sm:gap-4 border-b">
                                <dt class="text-xs sm:text-sm font-medium text-gray-500 sm:col-span-2 lg:col-span-2">Waktu Mengerjakan</dt>
                                <dd class="mt-1 text-xs sm:text-sm font-medium text-gray-900 sm:mt-0 sm:col-span-2 lg:col-span-5">100 Menit</dd>
                            </div>
                            <div class="py-4 sm:py-5 sm:flex sm:space-x-2 justify-start">
                                <button id="btn-prepare" type="button" class="bg-indigo-500 hover:bg-indigo-600 w-full sm:w-48 text-white font-medium text-sm px-4 py-3 rounded-md shadow-lg flex justify-center items-center mr-2 mb-2">Mulai Mengerjakan</button>
                                <a type="button" href="{{ route('tryout.index') }}" class="bg-pink-500 hover:bg-pink-600 w-full sm:w-48 text-white font-medium text-sm px-4 py-3 rounded-md shadow-lg flex justify-center items-center mr-2 mb-2">Kembali</a>
                            </div>
                        </dl>
                    </div>
                </div>
                <div class="fixed z-10 inset-0 overflow-y-auto alert-overflow" style="display: none;">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div aria-hidden="true" class="fixed inset-0 transition-opacity alert-background" style="display: none;">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <span aria-hidden="true" class="hidden sm:inline-block sm:align-middle sm:h-screen">​</span>
                        <div role="dialog" aria-modal="true" aria-labelledby="modal-headline" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full alert-content" style="display: none;">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="h-6 w-6 text-yellow-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <h3 id="modal-headline" class="text-lg leading-6 font-medium text-gray-900">Perhatian Sebelum Mengerjakan</h3>
                                        <div class="mt-2">
                                            <li> Disarankan menggunakan browser Google Chrome versi terbaru supaya website dapat diakses dengan lancar tanpa masalah. </li>
                                            <li> Pastikan koneksi internet stabil saat mengerjakan dan submit jawaban. </li>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <a href="#" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition start-exam-btn" data-tryout-id="{{ $tryout->id }}">Kerjakan Sekarang</a>
                                <button id="btn-prepare-cancel" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fixed z-10 inset-0 overflow-y-auto" style="display: none;">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div aria-hidden="true" class="fixed inset-0 transition-opacity" style="display: none;">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <span aria-hidden="true" class="hidden sm:inline-block sm:align-middle sm:h-screen">​</span>
                        <div role="dialog" aria-modal="true" aria-labelledby="modal-headline" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" style="display: none;">
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
                                <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition"> Ya, Lanjut Mengerjakan </button>
                                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"> Tidak </button>
                            </div>
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
            e.preventDefault(); // Mencegah reload halaman

            let tryout_id = $(this).data("tryout-id");

            $.ajax({
                url: "{{ route('tryout.exam') }}",  // Route untuk menyimpan userExam
                type: "POST",
                data: {
                    tryout_id: tryout_id,
                    _token: "{{ csrf_token() }}" // Token Laravel untuk keamanan
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
            $('.alert-overflow, .alert-background, .alert-content').fadeIn("fast");;
        })

        $('#btn-prepare-cancel').on('click', function(){
            $('.alert-overflow, .alert-background, .alert-content').fadeOut("fast");
        })
        
    </script>
@endpush