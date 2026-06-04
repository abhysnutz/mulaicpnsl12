@extends('frontend.layout')

@section('content')
<div class="pt-4 pb-20 sm:pt-6 sm:pb-6 bg-gray-50 min-h-screen">
    <div class="mx-auto px-4 sm:px-6 md:px-5">
        <div class="bg-white px-5 pt-5 pb-8 rounded-2xl shadow-sm border border-gray-100">

            {{-- Badge mode preview --}}
            <div class="mb-4 flex items-center justify-center">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Mode Preview &mdash; Tampilan seperti yang dilihat peserta
                </span>
            </div>

            <div class="flex items-start flex-col lg:flex-row">
                {{-- KIRI: Konten soal --}}
                <div class="w-full lg:w-4/6 2xl:w-4/5 lg:mr-5 mb-5">
                    {{-- Timer (mobile) --}}
                    <div class="overflow-hidden rounded-xl mb-5 lg:hidden bg-amber-50 border border-amber-100 shadow-sm">
                        <div class="px-4 py-4 text-center">
                            <span class="text-xs font-medium text-amber-600 uppercase tracking-wide">Waktu Tersisa</span>
                            <h4 class="font-bold text-4xl text-amber-600 mt-1">xx:xx:xx</h4>
                        </div>
                    </div>

                    <div class="px-5 py-6 sm:p-7 bg-white overflow-hidden shadow-md hover:shadow-lg transition-shadow border border-gray-100 rounded-2xl">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-800"> Soal No.
                                <span>X</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 ml-2 rounded-md text-sm font-bold bg-amber-500 text-white shadow-sm">
                                    {{ $question->topic->name ?? 'No Topic' }}
                                </span>
                            </h3>
                            <button type="button" class="flex justify-center bg-blue-100 text-blue-700 px-3 py-2 items-center rounded-lg shadow-sm hover:bg-blue-200 hover:shadow transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg> Bantuan
                            </button>
                        </div>
                        <hr class="my-4 border-gray-100">
                        <div>
                            <div class="question text-gray-700 leading-relaxed">
                                {!! $question->question !!}
                            </div>
                            <div class="options py-5">
                                @foreach($question->answers as $answer)
                                    <div class="flex items-center mb-2">
                                        <label class="w-full flex items-center p-3 rounded-lg border border-gray-200 cursor-not-allowed bg-gray-50">
                                            <input type="radio" disabled
                                                class="focus:ring-amber-500 h-4 w-4 text-amber-600 border-gray-300 mr-3">
                                            <span class="text-gray-700">{{ $answer->option }}. {!! $answer->answer !!}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <hr class="my-4 border-gray-100">

                        <div class="flex justify-center">
                            <button type="button" disabled class="flex items-center mx-2 px-4 py-2.5 text-sm leading-4 font-medium rounded-lg shadow-sm text-gray-400 bg-gray-100 cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                </svg> Sebelumnya
                            </button>
                            <button type="button" disabled class="flex items-center mx-2 px-4 py-2.5 text-sm leading-4 font-medium rounded-lg shadow-md text-white bg-amber-400 cursor-not-allowed"> Selanjutnya
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 ml-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- KANAN: Timer & Nomor Soal --}}
                <div class="w-full lg:w-2/6 2xl:w-1/5 flex flex-col">
                    {{-- Timer (desktop) --}}
                    <div class="overflow-hidden rounded-xl mb-5 hidden lg:block bg-amber-50 border border-amber-100 shadow-sm">
                        <div class="px-4 py-3 text-center">
                            <span class="text-xs font-medium text-amber-600 uppercase tracking-wide">Waktu Tersisa</span>
                            <h4 class="font-bold text-4xl text-amber-600 mt-1">xx:xx:xx</h4>
                        </div>
                    </div>

                    {{-- Nomor Soal (dummy) --}}
                    <div class="bg-white overflow-hidden shadow-md border border-gray-100 rounded-2xl mb-5">
                        <div class="px-4 py-4 font-semibold text-center text-gray-700 border-b border-gray-100">Nomor Soal</div>
                        <div class="flex flex-wrap px-3 py-3 justify-center">
                            @for ($i = 1; $i <= 20; $i++)
                                <button type="button" disabled
                                    class="{{ $i === 1 ? 'bg-amber-500 text-white ring-2 ring-amber-300 ring-offset-1' : 'bg-gray-200 text-gray-700' }} shadow-sm border border-gray-200 py-1.5 rounded-lg m-1 text-center w-9 font-medium cursor-not-allowed">
                                    {{ $i }}
                                </button>
                            @endfor
                        </div>
                        {{-- Legend --}}
                        <div class="flex items-center justify-center gap-4 px-4 pb-4 text-xs text-gray-500">
                            <span class="flex items-center"><span class="w-3 h-3 rounded bg-gray-200 mr-1.5"></span>Belum</span>
                            <span class="flex items-center"><span class="w-3 h-3 rounded bg-green-400 mr-1.5"></span>Terjawab</span>
                            <span class="flex items-center"><span class="w-3 h-3 rounded bg-amber-500 mr-1.5"></span>Aktif</span>
                        </div>
                    </div>

                    {{-- Tombol selesai (dummy) --}}
                    <div class="bg-white overflow-hidden shadow-md border border-gray-100 rounded-2xl mb-5 hidden lg:block">
                        <div class="px-4 py-5 sm:p-6 text-center">
                            <div class="font-semibold mb-3 text-gray-700">Sudah selesai ?</div>
                            <div class="flex justify-center">
                                <button type="button" disabled class="flex items-center mx-2 px-4 py-2.5 text-sm leading-4 font-medium rounded-lg shadow-sm text-red-400 bg-red-50 cursor-not-allowed">BATAL</button>
                                <button type="button" disabled class="flex items-center mx-2 px-4 py-2.5 text-sm leading-4 font-medium rounded-lg shadow-md text-white bg-amber-400 cursor-not-allowed">SELESAI</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css-top')
<style>
    /* Batasi ukuran gambar di soal & opsi jawaban agar layout tidak rusak */
    .question img,
    .options img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
        margin: 0.5rem 0;
    }
</style>
@endpush