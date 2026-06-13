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

                    <div class="card mb-4">

                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title mb-0">
                                Question Management
                                <span class="badge badge-info ml-2">{{ $questions->count() }} soal</span>
                            </h3>
                            <a href ="{{ route('console.question.create') }}" type="button" class="btn btn-primary btn-sm ml-auto">
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
                                        <th style="width: 10px">No</th>
                                        <th>Soal</th>
                                        <th>Kategori</th>
                                        <th>Topik</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($questions as $question)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ Str::limit(strip_tags($question?->question), 100) }}
                                                @if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $question?->question, $m))
                                                    <img src="{{ $m[1] }}" alt="Gambar soal" style="max-height:40px; margin-left:6px; vertical-align:middle;">
                                                @endif
                                            </td>
                                            <td>{{ $question?->topic?->category }}</td>
                                            <td>{{ $question?->topic?->name }}</td>
                                            <td class="d-flex align-items-center">
                                                <a href="{{ route('console.question.preview', $question->id) }}" target="_blank" class="btn btn-info btn-sm mr-2">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('console.question.clone', $question->id) }}" method="POST" class="mr-2">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-clone me-1"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ route('console.question.edit',$question->id) }}" class="btn btn-warning btn-sm mr-2">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form class="mr-2" action="{{ route('console.question.destroy',$question->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus question ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                Tidak ada soal yang cocok dengan filter.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
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

            // pertahankan pilihan topik jika masih valid, jika tidak reset ke "Semua Topik"
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