@extends('frontend.layout')
@section('content')
<div class="pt-4 pb-20 sm:pt-6 sm:pb-6" style="background-color:#f9fafb; min-height:100vh;">
    <div class="mx-auto px-4 sm:px-6 md:px-5">
        <div class="bg-white px-5 pt-5 pb-8 rounded-2xl shadow-sm border border-gray-100">
            @include('frontend.breadcrumb', ['content' => 'Tryout'])

            @if (session('error'))
                <div class="error-notification rounded-xl border-l-4 p-3 sm:p-4 mb-4" style="background-color:#fef2f2; border-color:#ef4444;">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="h-5 w-5 text-red-400">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-2 sm:ml-3">
                            <p class="text-xs sm:text-sm font-semibold text-red-600">Whoops!</p>
                            <p class="text-xs sm:text-sm font-medium text-red-500">{{ session('error') ?? '-' }}</p>
                        </div>
                        <div class="ml-auto pl-2 sm:pl-3">
                            <button onclick="$('.error-notification').hide()" class="inline-flex text-red-500 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-4 sm:h-5 w-4 sm:w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Subtitle -->
            <div class="mt-2 mb-6">
                <p class="text-sm text-gray-500">Uji pemahaman kamu dengan mengerjakan latihan soal dan try out.</p>
            </div>

            <ul role="list" class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($tryouts as $tryout)
                    @php
                        $access = strtolower((string) ($tryout->access_type ?? 'premium'));
                        if ($access === 'free') {
                            $badgeText = 'GRATIS';  $badgeBg = '#16a34a'; // hijau
                        } else {
                            $badgeText = 'PREMIUM'; $badgeBg = '#d97706'; // amber
                        }

                        // my_attempts berasal dari withCount() di controller.
                        // Fallback ke 0 jika controller belum mengirimnya.
                        $attemptCount = (int) ($tryout->my_attempts ?? 0);
                        $sudahDikerjakan = $attemptCount > 0;
                    @endphp

                    <li class="col-span-1 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow bg-white overflow-hidden flex flex-col">
                        <div class="p-4 flex-1">
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex items-start gap-3 min-w-0">
                                    <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-xl" style="background-color:#fef3c7;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6" style="color:#d97706;" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-gray-900 font-semibold text-sm sm:text-base leading-snug">{{ $tryout?->title }}</p>
                                        <div class="flex flex-wrap items-center gap-1.5 mt-1.5">
                                            @if($tryout?->type)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium" style="background-color:#f3f4f6; color:#4b5563;">{{ $tryout->type }}</span>
                                            @endif
                                            @if($tryout?->category)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium" style="background-color:#f3f4f6; color:#4b5563;">{{ $tryout->category }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <span class="flex-shrink-0 text-white text-xs font-bold px-2.5 py-1 rounded-md" style="background-color:{{ $badgeBg }};">{{ $badgeText }}</span>
                            </div>

                            <div class="flex items-center gap-4 mt-3 text-gray-500 text-xs sm:text-sm">
                                <span class="inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 mr-1" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    {{ $tryout?->questions?->count() ?? 0 }} Soal
                                </span>
                                <span class="inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 mr-1" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $tryout?->duration ?? 100 }} Menit
                                </span>
                            </div>

                            <!-- Status pengerjaan -->
                            <div class="mt-3">
                                @if($sudahDikerjakan)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium" style="background-color:#dcfce7; color:#166534;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 mr-1">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Sudah dikerjakan{{ $attemptCount > 1 ? " ({$attemptCount}x)" : '' }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium" style="background-color:#f3f4f6; color:#6b7280;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 mr-1" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Belum dikerjakan
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="px-4 pb-4">
                            <a href="{{ route('tryout.prepare',$tryout->id) }}"
                               class="btn-start bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 font-semibold text-sm rounded-lg shadow-sm hover:shadow inline-flex items-center justify-center w-full transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-2" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $sudahDikerjakan ? 'Kerjakan Ulang' : 'Kerjakan' }}
                            </a>
                        </div>
                    </li>
                @empty
                    <li class="col-span-full">
                        <div class="flex flex-col items-center justify-center py-16 text-center">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full mb-4" style="background-color:#fef3c7;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-8 h-8" style="color:#d97706;" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <p class="text-gray-700 font-medium">Belum ada tryout tersedia</p>
                            <p class="text-sm text-gray-400 mt-1">Tryout baru akan muncul di sini.</p>
                        </div>
                    </li>
                @endforelse
            </ul>

            @if(method_exists($tryouts, 'hasPages') && $tryouts->hasPages())
                <div class="mt-6">
                    {{ $tryouts->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('js-bottom')
    <script>
        $(document).on('click', '.btn-start', function (e) {
            var $btn = $(this);

            // If already clicked (loading), block subsequent clicks
            if ($btn.data('loading')) { e.preventDefault(); return false; }

            // Mark as loading
            $btn.data('loading', true);

            // Disable interaction
            $btn.css({ 'pointer-events': 'none', 'opacity': '0.6' });

            // Swap text for spinner
            $btn.html(
                '<svg class="animate-spin w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">' +
                '<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>' +
                '<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>' +
                '</svg> Loading...'
            );
        });
    </script>
@endpush