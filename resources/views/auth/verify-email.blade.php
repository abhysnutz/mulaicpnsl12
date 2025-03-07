@extends('frontend.layout')
@section('content')
    <div class="py-6">
        <div class="mx-auto px-4 sm:px-6 md:px-8">
            <div class="relative sm:py-4">
                <div class="mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">
                    <div class="relative rounded-2xl px-6 py-10 bg-indigo-600 overflow-hidden shadow-xl sm:px-12 sm:py-10">
                        <div aria-hidden="true" class="absolute inset-0 -mt-72 sm:-mt-32 md:mt-0">
                            <svg preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 1463 360" class="absolute inset-0 h-full w-full">
                                <path fill="currentColor" d="M-82.673 72l1761.849 472.086-134.327 501.315-1761.85-472.086z" class="text-indigo-500 text-opacity-40"></path>
                                <path fill="currentColor" d="M-217.088 544.086L1544.761 72l134.327 501.316-1761.849 472.086z" class="text-indigo-700 text-opacity-40"></path>
                            </svg>
                        </div>
                        <div class="relative">
                            <div class="sm:text-center">
                                <h2 class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl"> Verifikasi Email </h2>
                                <p class="mt-3 mx-auto max-w-2xl text-lg text-indigo-200"> Hai kak test, <br> Periksa kotak masuk email kamu untuk verifikasi. <br> Apabila kamu belum menerima email dari kami, silakan cek spam juga, ya! </p>
                            </div>
                            <div class="sm:text-center mt-5">
                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-400 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="-ml-1 mr-3 h-5 w-5">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                        </svg> Kirim Ulang Link Verifikasi
                                    </button>
                                </form>
                            </div>
                            @if (session('status') == 'verification-link-sent')
                                <p class="text-center mt-4 text-indigo-200">
                                    Email verifikasi berhasil dikirim. Silakan periksa kotak masuk dan spam.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection

