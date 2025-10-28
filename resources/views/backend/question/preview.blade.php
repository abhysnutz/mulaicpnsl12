@extends('frontend.layout')

@section('content')
<div class="pt-4 pb-20 sm:pt-6 sm:pb-6">
    <div class="mx-auto px-4 sm:px-6 md:px-5">
        <div class="bg-white px-5 pt-5 pb-8 rounded-lg">
            <div class="flex items-start flex-col lg:flex-row">
                <!-- KIRI: Konten soal -->
                <div class="w-full lg:w-4/6 2xl:w-4/5 lg:mr-5 mb-5">
                    <div class="bg-white px-5 pt-5 pb-8 rounded-lg shadow-lg">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-medium"> Soal No. X
                                <span class="inline-flex items-center px-2.5 py-0.5 ml-2 rounded-md text-sm font-bold bg-amber-500 text-white">
                                    {{ $question->topic->name ?? 'No Topic' }}
                                </span>
                            </h3>
                            <button id="btn-working-help" class="flex justify-center bg-blue-200 text-blue-700 px-3 py-2 items-center rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg> Bantuan 
                            </button>
                        </div>
                       

                        <hr class="my-4">

                        <div class="question">
                            {!! $question->question !!}
                        </div>

                        <div class="options py-5">
                            @foreach($question->answers as $answer)
                                <div class="flex items-center mb-2">
                                    <label class="ml-3 w-full flex items-center">
                                        <input type="radio" disabled
                                            class="focus:ring-amber-500 h-4 w-4 text-amber-600 border-gray-300 mr-2">
                                        <span class="translate-y-2">
                                            {{ $answer->option }}. {!! $answer->answer !!}
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- KANAN: Timer & Nomor Soal -->
                <div class="w-full lg:w-2/6 2xl:w-1/5 flex flex-col">
                    <!-- Timer dummy -->
                    <div class="bg-white overflow-hidden rounded-lg mb-5 shadow-lg">
                        <div class="px-4 py-2 text-center">
                            <h4 id="preview-timer" class="font-bold text-4xl text-gray-800">
                                xx:xx:xx
                            </h4>
                            <span class="text-sm text-gray-500">Waktu tersisa</span>
                        </div>
                    </div>

                    <!-- Nomor Soal 1–20 -->
                    <div class="bg-white overflow-hidden rounded-lg shadow-lg">
                        <div class="px-4 py-5 sm:py-3 font-medium text-center border-b">
                            Nomor Soal
                        </div>
                        <div class="flex flex-wrap px-3 py-2 justify-center">
                            @for ($i = 1; $i <= 20; $i++)
                                <button class="bg-gray-200 hover:bg-amber-500 hover:text-white rounded w-9 py-1.5 m-1 font-medium">
                                    {{ $i }}
                                </button>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
