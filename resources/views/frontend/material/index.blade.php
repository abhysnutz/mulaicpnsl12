@extends('frontend.layout')

@push('css-top')
<style>
    .mtr-tab { transition: all .15s; cursor: pointer; }
    .mtr-card { transition: transform .15s, box-shadow .15s; }
    .mtr-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px -5px rgba(0,0,0,.1); }
    .mtr-dl { transition: all .15s; }
    .mtr-dl:hover { transform: scale(1.03); }
</style>
@endpush

@section('content')
<div class="pt-4 pb-20 sm:pt-6 sm:pb-6" style="background-color:#f9fafb; min-height:100vh;">
    <div class="mx-auto px-4 sm:px-6 md:px-5">
        <div class="bg-white px-5 pt-5 pb-8 rounded-2xl shadow-sm border border-gray-100">
            @include('frontend.breadcrumb', ['content' => 'Materi'])

            <div class="mt-2 mb-5">
                <p class="text-sm" style="color:#6b7280;">Unduh materi pembelajaran dalam format PDF per topik.</p>
            </div>

            @if (! $isPaid)
                <div class="rounded-xl p-4 mb-5" style="background:linear-gradient(135deg,#fffbeb 0%,#fef3c7 100%); border:1px solid #fcd34d;">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center rounded-full mr-3" style="width:40px;height:40px;background-color:#d97706;flex-shrink:0;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#ffffff" style="width:22px;height:22px;">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold" style="color:#92400e;">Materi khusus pengguna premium</p>
                            <p class="text-xs mt-0.5" style="color:#b45309;">Upgrade akun untuk membuka semua materi. <a href="{{ route('petunjuk_upgrade') }}" class="font-semibold underline">Cara upgrade &rarr;</a></p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Tab filter --}}
            <div class="flex flex-wrap items-center gap-2 mb-4" id="mtrTabs">
                @php $tabs = ['Semua' => 'all', 'TWK' => 'TWK', 'TIU' => 'TIU', 'TKP' => 'TKP']; @endphp
                @foreach ($tabs as $label => $val)
                    <button type="button" class="mtr-tab text-sm font-semibold rounded-lg px-4 py-2" data-filter="{{ $val }}"
                        style="{{ $loop->first ? 'background-color:#d97706;color:#fff;' : 'background-color:#f3f4f6;color:#4b5563;' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            {{-- Search --}}
            <div class="relative mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#9ca3af" style="width:18px;height:18px;position:absolute;left:14px;top:50%;transform:translateY(-50%);">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
                <input type="text" id="mtrSearch" placeholder="Ketik untuk mencari materi..."
                    class="w-full text-sm rounded-xl"
                    style="padding:12px 14px 12px 42px;border:1px solid #e5e7eb;outline:none;color:#374151;"
                    onfocus="this.style.borderColor='#d97706'" onblur="this.style.borderColor='#e5e7eb'">
            </div>

            {{-- Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="mtrGrid">
                @forelse ($materials as $material)
                    @php
                        $cat = $material->topic->category;
                        $palette = [
                            'TWK' => ['#e6f1fb', '#185fa5'],
                            'TIU' => ['#faeeda', '#854f0b'],
                            'TKP' => ['#e1f5ee', '#0f6e56'],
                        ];
                        [$iconBg, $iconColor] = $palette[$cat] ?? ['#f3f4f6', '#4b5563'];
                    @endphp
                    <div class="mtr-card rounded-2xl border p-4 flex flex-col"
                         data-category="{{ $cat }}"
                         data-search="{{ Str::lower($material->title . ' ' . $material->topic->name) }}"
                         style="border-color:#f3f4f6;background-color:#fff;">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center justify-center rounded-xl" style="width:48px;height:48px;background-color:{{ $iconBg }};">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="{{ $iconColor }}" style="width:26px;height:26px;">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-bold rounded-md px-2 py-1" style="background-color:{{ $iconBg }};color:{{ $iconColor }};">{{ $cat }}</span>
                        </div>
                        <p class="font-semibold text-sm leading-snug mb-1" style="color:#111827;">{{ $material->title }}</p>
                        <p class="text-xs mb-4" style="color:#9ca3af;">{{ $material->topic->name }} &middot; {{ $material->readable_size }}</p>
                        <div class="mt-auto">
                            @if ($isPaid)
                                <a href="{{ route('material.download', $material->id) }}"
                                   class="mtr-dl flex items-center justify-center w-full text-white text-sm font-semibold rounded-lg py-2.5"
                                   style="background-color:#d97706;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;margin-right:6px;">
                                        <path d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2z"></path>
                                    </svg>
                                    Unduh
                                </a>
                            @else
                                <div class="flex items-center justify-center w-full text-sm font-semibold rounded-lg py-2.5" style="background-color:#f3f4f6;color:#9ca3af;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:16px;height:16px;margin-right:6px;">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Terkunci
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                        <p class="font-medium" style="color:#374151;">Belum ada materi tersedia</p>
                    </div>
                @endforelse
            </div>

            {{-- Empty state untuk hasil filter/search --}}
            <div id="mtrEmpty" class="hidden flex-col items-center justify-center py-16 text-center">
                <p class="font-medium" style="color:#374151;">Materi tidak ditemukan</p>
                <p class="text-sm mt-1" style="color:#9ca3af;">Coba kata kunci atau kategori lain.</p>
            </div>

        </div>
    </div>
</div>
@endsection

@push('js-bottom')
<script>
    (function () {
        var tabs   = document.querySelectorAll('#mtrTabs .mtr-tab');
        var cards  = document.querySelectorAll('#mtrGrid .mtr-card');
        var search = document.getElementById('mtrSearch');
        var empty  = document.getElementById('mtrEmpty');
        var grid   = document.getElementById('mtrGrid');
        var activeFilter = 'all';

        function apply() {
            var q = (search.value || '').toLowerCase().trim();
            var visible = 0;
            cards.forEach(function (card) {
                var matchCat = activeFilter === 'all' || card.getAttribute('data-category') === activeFilter;
                var matchSearch = !q || card.getAttribute('data-search').indexOf(q) !== -1;
                var show = matchCat && matchSearch;
                card.style.display = show ? 'flex' : 'none';
                if (show) visible++;
            });
            empty.style.display = visible === 0 ? 'flex' : 'none';
            grid.style.display = visible === 0 ? 'none' : 'grid';
        }

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                activeFilter = tab.getAttribute('data-filter');
                tabs.forEach(function (t) {
                    t.style.backgroundColor = '#f3f4f6';
                    t.style.color = '#4b5563';
                });
                tab.style.backgroundColor = '#d97706';
                tab.style.color = '#fff';
                apply();
            });
        });

        search.addEventListener('input', apply);
    })();
</script>
@endpush