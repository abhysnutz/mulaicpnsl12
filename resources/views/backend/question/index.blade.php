@extends('backend.layout.app')
@push('css-top')
<style>
/* Batasi ukuran gambar soal di dalam tabel */
.table td img {
    max-height: 50px;
    width: auto;
    vertical-align: middle;
    cursor: pointer;        /* tanda bisa diklik */
    transition: opacity .15s;
}
.table td img:hover {
    opacity: .8;
}
/* popover daftar tryout */
.popover { max-width: 320px; }
.popover-body ul { margin: 0; padding-left: 1.1rem; }
.popover-body ul li { margin-bottom: .2rem; }
/* header sortable */
.sort-link { color: inherit; text-decoration: none; }
.sort-link:hover { text-decoration: underline; }
/* cegah pilih teks saat shift-click range */
.row-check { user-select: none; }
</style>
@endpush
@section('content')
    @include('backend.layout.breadcrumb',['content' => 'Question' ])
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    {{-- Import & Export Bar --}}
                    <div class="card-body border-bottom pb-3">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">

                            {{-- Export & Template --}}
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('console.question.export') }}" class="btn btn-success d-flex align-items-center shadow-sm mr-2">
                                    <i class="fas fa-file-export mr-2"></i> Export Soal
                                </a>

                                <a href="{{ asset('template_import_soal_cpns.xlsx') }}" target="_blank" class="btn btn-secondary d-flex align-items-center shadow-sm">
                                    <i class="fas fa-download mr-2"></i> Download Template
                                </a>
                            </div>

                            {{-- Import Form (AJAX 2-tahap: analyze -> review -> commit) --}}
                            <form id="importForm" class="d-flex align-items-center gap-2 flex-wrap"
                                  data-analyze="{{ route('console.question.import.analyze') }}"
                                  data-commit="{{ route('console.question.import.commit') }}">
                                @csrf
                                <div class="input-group">
                                    <div class="custom-file mr-2">
                                        <input type="file" name="file" id="importFile" class="custom-file-input"
                                               accept=".zip,.xlsx,.xls" required>
                                        <label class="custom-file-label" for="importFile">
                                            <i class="fas fa-file-excel mr-2"></i> Pilih File Excel/ZIP...
                                        </label>
                                    </div>
                                    <div class="input-group-append">
                                        <button id="btnAnalyze" class="btn btn-primary d-flex align-items-center shadow-sm" type="submit">
                                            <i class="fas fa-search mr-2"></i> Cek &amp; Import
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Filter Bar --}}
                    <div class="card mb-3">
                        <div class="card-body py-3">
                            <form method="GET" action="{{ route('console.question.index') }}" class="form-row align-items-end">
                                <div class="form-group col-md-3 mb-2 mb-md-0">
                                    <label for="filterCategory">Kategori</label>
                                    <select name="category" id="filterCategory" class="form-control">
                                        <option value="">Semua Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4 mb-2 mb-md-0">
                                    <label for="filterTopic">Topik</label>
                                    <select name="topic_id" id="filterTopic" class="form-control">
                                        <option value="">Semua Topik</option>
                                        @foreach ($topics as $topic)
                                            <option value="{{ $topic->id }}"
                                                    data-category="{{ $topic->category }}"
                                                    {{ request('topic_id') == $topic->id ? 'selected' : '' }}>
                                                {{ $topic->category }} - {{ $topic->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-5 mb-0">
                                    <button type="submit" class="btn btn-primary mr-2">
                                        <i class="fas fa-filter mr-1"></i> Filter
                                    </button>
                                    <a href="{{ route('console.question.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-undo mr-1"></i> Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Form bulk delete membungkus tabel --}}
                    <form id="bulkDeleteForm" action="{{ route('console.question.bulk-destroy') }}" method="POST"
                          onsubmit="return confirm('Hapus semua soal yang dipilih? Tindakan ini tidak bisa dibatalkan.');">
                        @csrf
                        @method('DELETE')

                        <div class="card mb-4">

                            <div class="card-header d-flex align-items-center flex-wrap">
                                <h3 class="card-title mb-0">
                                    Question Management
                                    <span class="badge badge-info ml-2">
                                        {{ $isFiltered ? $questions->count() : $questions->total() }} soal
                                    </span>
                                </h3>

                                {{-- Tombol hapus terpilih: muncul saat ada yang dicentang --}}
                                <button type="submit" id="btnBulkDelete" class="btn btn-danger btn-sm ml-3" style="display:none;">
                                    <i class="fas fa-trash mr-1"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
                                </button>

                                <a href="{{ route('console.question.create') }}" type="button" class="btn btn-primary btn-sm ml-auto">
                                    <strong>
                                        <i class="fas fa-plus fa-fw mr-1"></i>
                                        <span style="letter-spacing: 0.05em;">CREATE</span>
                                    </strong>
                                </a>
                            </div>

                            <div class="card-body table-responsive p-0">
                                <table class="table table-head-fixed text-nowrap">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">
                                                <input type="checkbox" id="checkAll" aria-label="Pilih semua soal">
                                            </th>
                                            <th style="width: 10px">No</th>
                                            <th>Soal</th>
                                            <th>Kategori</th>
                                            <th>Topik</th>
                                            <th style="width: 90px">
                                                @php
                                                    $nextDir = ($sort === 'tryout_count' && $dir === 'desc') ? 'asc' : 'desc';
                                                    $sortParams = array_merge(request()->query(), ['sort' => 'tryout_count', 'dir' => $nextDir]);
                                                @endphp
                                                <a href="{{ route('console.question.index', $sortParams) }}" class="sort-link" title="Urutkan berdasarkan jumlah tryout">
                                                    Tryout
                                                    @if ($sort === 'tryout_count')
                                                        <i class="fas fa-sort-{{ $dir === 'asc' ? 'up' : 'down' }}"></i>
                                                    @else
                                                        <i class="fas fa-sort text-muted"></i>
                                                    @endif
                                                </a>
                                            </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($questions as $question)
                                            <tr class="align-middle">
                                                <td>
                                                    <input type="checkbox" name="ids[]" value="{{ $question->id }}"
                                                           class="row-check" aria-label="Pilih soal #{{ $question->id }}">
                                                </td>
                                                <td>{{ $isFiltered ? $loop->iteration : ($questions->firstItem() + $loop->index) }}</td>
                                                <td>
                                                    {{ Str::limit(strip_tags($question?->question), 100) }}
                                                    @if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $question?->question, $m))
                                                        <img src="{{ $m[1] }}" alt="Gambar soal" style="max-height:40px; margin-left:6px; vertical-align:middle;">
                                                    @endif
                                                </td>
                                                <td>{{ $question?->topic?->category }}</td>
                                                <td>{{ $question?->topic?->name }}</td>
                                                <td>
                                                    @if ($question->tryouts_count > 0)
                                                        @php
                                                            $tryoutTitles = $question->tryouts->pluck('title')->all();
                                                            $popoverHtml  = '<ul>' . collect($tryoutTitles)
                                                                ->map(fn ($t) => '<li>' . e($t) . '</li>')
                                                                ->implode('') . '</ul>';
                                                        @endphp
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-info tryout-popover"
                                                                data-toggle="popover"
                                                                data-html="true"
                                                                data-trigger="focus"
                                                                title="Dipakai di {{ $question->tryouts_count }} tryout"
                                                                data-content="{{ $popoverHtml }}"
                                                                aria-label="Soal ini dipakai di {{ $question->tryouts_count }} tryout. Klik untuk lihat daftar.">
                                                            <i class="fas fa-list-ol mr-1"></i> {{ $question->tryouts_count }}
                                                        </button>
                                                    @else
                                                        <span class="badge badge-secondary" title="Belum dipakai di tryout manapun">0</span>
                                                    @endif
                                                </td>
                                                <td class="d-flex align-items-center">
                                                    <a href="{{ route('console.question.preview', $question->id) }}" target="_blank" class="btn btn-info btn-sm mr-2">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-primary mr-2 btn-clone"
                                                            data-action="{{ route('console.question.clone', $question->id) }}">
                                                        <i class="fas fa-clone"></i>
                                                    </button>
                                                    <a href="{{ route('console.question.edit',$question->id) }}" class="btn btn-warning btn-sm mr-2">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm btn-single-delete"
                                                            data-action="{{ route('console.question.destroy', $question->id) }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    Tidak ada soal yang cocok dengan filter.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->

                            {{-- Pagination hanya saat tidak difilter, di tengah --}}
                            @unless ($isFiltered)
                                <div class="card-footer d-flex justify-content-center">
                                    {{ $questions->links('pagination::bootstrap-4') }}
                                </div>
                            @endunless
                        </div>
                    </form>

                    {{-- form tersembunyi untuk clone & single delete (di luar bulk form agar tidak nested) --}}
                    <form id="actionForm" method="POST" style="display:none;">
                        @csrf
                        <input type="hidden" name="_method" id="actionMethod" value="POST">
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal preview gambar --}}
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Gambar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="imagePreviewTarget" src="" style="max-width:100%; height:auto;">
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: Review Import --}}
    <div class="modal fade" id="importReviewModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-clipboard-check mr-2"></i> Review Import Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="reviewSummary" class="mb-3"></div>
                    <div style="max-height: 50vh; overflow-y:auto;">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:70px">Baris</th>
                                    <th style="width:70px">No</th>
                                    <th>Kategori - Topik</th>
                                    <th style="width:90px">Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="reviewTableBody"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" id="btnCommitImport" class="btn btn-success" style="display:none;">
                        <i class="fas fa-check mr-1"></i> Lanjutkan Import
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js-bottom')
    <script>
        // Ganti label saat pilih file
        document.querySelector('.custom-file-input').addEventListener('change', function (e) {
            const fileName = e.target.files[0].name;
            e.target.nextElementSibling.innerText = fileName;
        });

        // Klik gambar di tabel -> buka modal preview besar
        $(document).on('click', '.table td img', function () {
            $('#imagePreviewTarget').attr('src', $(this).attr('src'));
            $('#imagePreviewModal').modal('show');
        });

        // ============================
        // Popover daftar tryout
        // ============================
        $('[data-toggle="popover"]').popover({ container: 'body' });

        // ============================
        // Bulk select & delete + shift-click range
        // ============================
        const $checkAll      = $('#checkAll');
        const $btnBulkDelete = $('#btnBulkDelete');
        const $selectedCount = $('#selectedCount');
        let lastChecked = null;   // index checkbox terakhir yang diklik (untuk shift-range)

        function refreshBulkUI() {
            const total   = $('.row-check').length;
            const checked = $('.row-check:checked').length;
            $selectedCount.text(checked);
            $btnBulkDelete.toggle(checked > 0);
            // sinkronkan state checkAll
            $checkAll.prop('checked', total > 0 && checked === total);
            $checkAll.prop('indeterminate', checked > 0 && checked < total);
        }

        // "select all" di header
        $checkAll.on('change', function () {
            $('.row-check').prop('checked', this.checked);
            lastChecked = null;   // reset anchor shift setelah select-all
            refreshBulkUI();
        });

        // klik checkbox baris: tangani klik biasa DAN shift+klik (range)
        $(document).on('click', '.row-check', function (e) {
            const $checks = $('.row-check');        // semua checkbox baris, urut sesuai tampilan
            const idx     = $checks.index(this);    // posisi checkbox yang baru diklik (0-based)

            if (e.shiftKey && lastChecked !== null) {
                const start = Math.min(idx, lastChecked);
                const end   = Math.max(idx, lastChecked);
                const state = this.checked;         // ikuti state checkbox yang baru diklik
                $checks.slice(start, end + 1).prop('checked', state);
            }

            lastChecked = idx;
            refreshBulkUI();
        });

        // ============================
        // Clone & single delete (pakai form tersembunyi terpisah)
        // ============================
        $(document).on('click', '.btn-clone', function () {
            const action = $(this).data('action');
            const $f = $('#actionForm');
            $f.attr('action', action);
            $('#actionMethod').val('POST');
            $f.trigger('submit');
        });

        $(document).on('click', '.btn-single-delete', function () {
            if (!confirm('Apakah Anda yakin ingin menghapus question ini?')) return;
            const action = $(this).data('action');
            const $f = $('#actionForm');
            $f.attr('action', action);
            $('#actionMethod').val('DELETE');
            $f.trigger('submit');
        });

        // ============================
        // Filter: topik mengikuti kategori terpilih
        // ============================
        const $filterCategory = $('#filterCategory');
        const $filterTopic    = $('#filterTopic');
        const allTopicOptions = $filterTopic.find('option').clone();

        function syncTopicOptions() {
            const cat      = $filterCategory.val();
            const selected = $filterTopic.val();

            $filterTopic.empty();
            allTopicOptions.each(function () {
                const $opt = $(this);
                if (!cat || !$opt.val() || $opt.data('category') === cat) {
                    $filterTopic.append($opt.clone());
                }
            });

            if ($filterTopic.find(`option[value="${selected}"]`).length) {
                $filterTopic.val(selected);
            } else {
                $filterTopic.val('');
            }
        }

        $filterCategory.on('change', syncTopicOptions);
        syncTopicOptions();
    </script>
@endpush