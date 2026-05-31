@extends('frontend.layout')
@section('content')
<div class="pt-4 pb-20 sm:pt-6 sm:pb-6" style="background-color:#f9fafb; min-height:100vh;">
    <div class="mx-auto px-4 sm:px-6 md:px-5">
        <div class="bg-white px-5 pt-5 pb-8 rounded-2xl shadow-sm border border-gray-100">
            @include('frontend.breadcrumb', ['content' => 'Statistik'])

            <div id="tryout" class="w-full flex flex-col mt-4">
                <div class="flex flex-col sm:flex-row sm:items-center mb-4">
                    <h5 class="text-lg font-semibold text-gray-800 sm:w-32 flex-shrink-0">Tryout</h5>
                    <p class="text-base text-gray-600 sm:ml-2">{{ $exam?->tryout?->title }}</p>
                </div>

                <!-- Tabs -->
                <div class="border-b border-gray-200">
                    <nav aria-label="Tabs" class="-mb-px flex space-x-8">
                        <a href="#" class="group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm border-amber-500 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="-ml-0.5 mr-2 h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 13v-1m4 1v-3m4 3V8M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                            <span>Statistik</span>
                        </a>
                        <a href="{{ route('tryout.result.explanation', $exam->id) }}" class="group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="-ml-0.5 mr-2 h-5 w-5 text-gray-400 group-hover:text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <span>Pembahasan</span>
                        </a>
                    </nav>
                </div>

                @php
                    $score   = (int) ($exam?->result?->total_score ?? 0);
                    $maxScore = 550;
                    $pct = $maxScore > 0 ? min(100, round($score / $maxScore * 100)) : 0;
                    // keliling lingkaran r=80 => 2*pi*80 ≈ 502.65
                    $circ = 502.65;
                    $dash = $circ * (1 - $pct / 100);
                    $passed = $exam?->result?->is_passed;

                    $cats = [
                        ['label' => 'TWK', 'name' => 'Tes Wawasan Kebangsaan',  'val' => (int)($exam?->result?->total_twk ?? 0), 'pass' => (int)($data['passing_grade_twk'] ?? 65),  'max' => 150],
                        ['label' => 'TIU', 'name' => 'Tes Intelegensia Umum',   'val' => (int)($exam?->result?->total_tiu ?? 0), 'pass' => (int)($data['passing_grade_tiu'] ?? 80),  'max' => 175],
                        ['label' => 'TKP', 'name' => 'Tes Karakteristik Pribadi','val' => (int)($exam?->result?->total_tkp ?? 0), 'pass' => (int)($data['passing_grade_tkp'] ?? 166), 'max' => 225],
                    ];
                @endphp

                <!-- Kartu skor utama -->
                <div class="mt-6 grid grid-cols-1 lg:grid-cols-5 gap-5">
                    <!-- Donut skor -->
                    <div class="lg:col-span-2 p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-center justify-center"
                         style="background-color:#fffbeb;">
                        <p class="text-sm font-bold uppercase tracking-wide" style="color:#b45309;">Skor Akhir</p>
                        <div class="relative my-4" style="width:200px; height:200px;">
                            <svg width="200" height="200" viewBox="0 0 200 200">
                                <circle cx="100" cy="100" r="80" fill="none" stroke="#fde68a" stroke-width="16"></circle>
                                <circle cx="100" cy="100" r="80" fill="none" stroke="#d97706" stroke-width="16"
                                        stroke-linecap="round"
                                        stroke-dasharray="{{ $circ }}"
                                        stroke-dashoffset="{{ $dash }}"
                                        transform="rotate(-90 100 100)"></circle>
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-5xl font-bold text-gray-900">{{ $score }}</span>
                                <span class="text-sm font-medium text-gray-500">dari {{ $maxScore }}</span>
                            </div>
                        </div>
                        @if($passed)
                            <span class="inline-flex items-center px-6 py-2 rounded-full text-sm font-bold"
                                  style="background-color:#dcfce7; color:#166534; border:1px solid #22c55e;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 mr-1.5">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                LULUS
                            </span>
                        @else
                            <span class="inline-flex items-center px-6 py-2 rounded-full text-sm font-bold"
                                  style="background-color:#fee2e2; color:#991b1b; border:1px solid #ef4444;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 mr-1.5">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                TIDAK LULUS
                            </span>
                        @endif
                    </div>

                    <!-- Breakdown per kategori -->
                    <div class="lg:col-span-3 p-6 rounded-2xl border border-gray-100 shadow-sm bg-white">
                        <h3 class="text-base font-bold text-gray-900 mb-1">Rincian Nilai</h3>
                        <p class="text-sm text-gray-500 mb-5">Nilai per kategori dibanding passing grade</p>

                        <div class="space-y-5">
                            @foreach($cats as $c)
                                @php
                                    $ok = $c['val'] >= $c['pass'];
                                    $barPct = $c['max'] > 0 ? min(100, round($c['val'] / $c['max'] * 100)) : 0;
                                    $passMarker = $c['max'] > 0 ? min(100, round($c['pass'] / $c['max'] * 100)) : 0;
                                    $barColor = $ok ? '#22c55e' : '#ef4444';
                                @endphp
                                <div>
                                    <div class="flex items-center justify-between mb-1.5">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-xs font-bold text-white"
                                                  style="background-color:#d97706;">{{ $c['label'] }}</span>
                                            <span class="text-sm text-gray-600">{{ $c['name'] }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-lg font-bold" style="color:{{ $barColor }};">{{ $c['val'] }}</span>
                                            <span class="text-xs text-gray-400">/ PG {{ $c['pass'] }}</span>
                                            @if($ok)
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5" style="color:#22c55e;">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5" style="color:#ef4444;">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- progress bar dengan marker passing grade -->
                                    <div class="relative w-full h-3 rounded-full overflow-hidden" style="background-color:#f3f4f6;">
                                        <div class="absolute left-0 top-0 h-full rounded-full"
                                             style="width:{{ $barPct }}%; background-color:{{ $barColor }};"></div>
                                        <div class="absolute top-0 h-full"
                                             style="left:{{ $passMarker }}%; width:2px; background-color:#9ca3af;"
                                             title="Passing Grade"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <p class="text-xs text-gray-400 mt-4">Garis abu pada bar menandai posisi passing grade.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection