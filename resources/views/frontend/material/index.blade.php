@extends('frontend.layout')
@section('content')
<div class="pt-4 pb-20 sm:pt-6 sm:pb-6" style="background-color:#f9fafb; min-height:100vh;">
    <div class="mx-auto px-4 sm:px-6 md:px-5">
        <div class="bg-white px-5 pt-5 pb-8 rounded-2xl shadow-sm border border-gray-100">
            @include('frontend.breadcrumb', ['content' => 'Materi'])

            <!-- Subtitle -->
            <div class="mt-2 mb-6">
                <p class="text-sm" style="color:#6b7280;">Unduh materi pembelajaran dalam format PDF per topik.</p>
            </div>

            @if (! $isPaid)
                <div class="rounded-xl border-l-4 p-3 sm:p-4 mb-6" style="background-color:#fffbeb; border-color:#d97706;">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5" style="color:#d97706;">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-2 sm:ml-3">
                            <p class="text-xs sm:text-sm font-semibold" style="color:#92400e;">Materi hanya untuk pengguna premium</p>
                            <p class="text-xs sm:text-sm font-medium mt-0.5" style="color:#b45309;">Upgrade akun untuk mengunduh seluruh materi.</p>
                            <a href="{{ route('petunjuk_upgrade') }}" class="inline-block mt-1.5 text-xs sm:text-sm font-semibold underline" style="color:#d97706;">Cara upgrade &rarr;</a>
                        </div>
                    </div>
                </div>
            @endif

            @forelse ($materials as $category => $items)
                <div class="mb-6">
                    <h2 class="text-base sm:text-lg font-semibold mb-3" style="color:#1f2937;">{{ $category }}</h2>
                    <ul role="list" class="grid grid-cols-1 gap-3 md:grid-cols-2">
                        @foreach ($items as $material)
                            <li class="rounded-2xl border shadow-sm hover:shadow-md transition-shadow overflow-hidden flex items-center justify-between p-4" style="border-color:#f3f4f6; background-color:#ffffff;">
                                <div class="flex items-start gap-3 min-w-0">
                                    <div class="flex-shrink-0 flex items-center justify-center w-11 h-11 rounded-xl" style="background-color:#fee2e2;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6" style="color:#dc2626;">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-sm leading-snug" style="color:#111827;">{{ $material->title }}</p>
                                        <p class="text-xs mt-0.5" style="color:#6b7280;">{{ $material->topic->name }} &middot; {{ $material->readable_size }}</p>
                                        @if ($material->description)
                                            <p class="text-xs mt-1" style="color:#9ca3af;">{{ $material->description }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-3 flex-shrink-0">
                                    @if ($isPaid)
                                        <a href="{{ route('material.download', $material->id) }}"
                                           class="inline-flex items-center px-3 py-2 text-white text-xs sm:text-sm font-semibold rounded-lg shadow-sm hover:shadow transition-all"
                                           style="background-color:#d97706;"
                                           onmouseover="this.style.backgroundColor='#b45309'"
                                           onmouseout="this.style.backgroundColor='#d97706'">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 mr-1">
                                                <path d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2z"></path>
                                            </svg>
                                            Unduh
                                        </a>
                                    @else
                                        <span class="inline-flex items-center px-3 py-2 text-xs sm:text-sm font-semibold rounded-lg cursor-not-allowed" style="background-color:#e5e7eb; color:#9ca3af;">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 mr-1">
                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Terkunci
                                        </span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full mb-4" style="background-color:#fef3c7;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-8 h-8" style="color:#d97706;" stroke-width="1.5">
                            <path d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2z"></path>
                        </svg>
                    </div>
                    <p class="font-medium" style="color:#374151;">Belum ada materi tersedia</p>
                    <p class="text-sm mt-1" style="color:#9ca3af;">Materi baru akan muncul di sini.</p>
                </div>
            @endforelse

        </div>
    </div>
</div>
@endsection