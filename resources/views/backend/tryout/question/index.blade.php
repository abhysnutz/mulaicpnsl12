@extends('backend.layout.app')
@push('css-top')
<style>
tbody tr.cursor-move:hover {
    background-color: #e5e7eb; /* soft gray */
    cursor: grab;
}
tbody tr.cursor-move:active {
    cursor: grabbing;
}
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
    @include('backend.layout.breadcrumb',['content' => $tryout?->title.' | Question' ])
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    {{-- Import & Export Bar --}}
                    <div class="card-body border-bottom pb-3">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">

                            {{-- Export & Template --}}
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('console.tryout.question.export', $tryout->id) }}" class="btn btn-success d-flex align-items-center shadow-sm mr-2">
                                    <i class="fas fa-file-export mr-2"></i> Export Soal
                                </a>

                                <a href="{{ asset('template_import_soal_cpns.xlsx') }}" target="_blank" class="btn btn-secondary d-flex align-items-center shadow-sm">
                                    <i class="fas fa-download mr-2"></i> Download Template
                                </a>
                            </div>

                            {{-- Import Form (AJAX 2-tahap: analyze -> review -> commit) --}}
                            <form id="importForm" class="d-flex align-items-center gap-2 flex-wrap"
                                  data-analyze="{{ route('console.tryout.question.import.analyze', $tryout->id) }}"
                                  data-commit="{{ route('console.tryout.question.import.commit', $tryout->id) }}">
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

                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title mb-0">Daftar Soal</h3>
                            <div class="ml-auto">
                                <a href="{{ route('console.tryout.question.create', $tryout->id) }}" class="btn btn-primary btn-sm mr-2">
                                    <i class="fas fa-plus mr-1"></i> Buat Soal Baru
                                </a>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#bankModal">
                                    <i class="fas fa-database mr-1"></i> Tambah dari Bank Soal
                                </button>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0" style="height: 450px;">
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
                                <tbody id="sortable-question-list">
                                    @if ($questions->count())
                                        @foreach ($questions as $question)
                                            <tr class="align-middle cursor-move" data-id="{{ $question->id }}">
                                                <td class="text-center align-middle">
                                                    {{ $question?->pivot?->order }}
                                                </td>
                                                <td>
                                                    @php
                                                        $raw = $question?->question ?? '';
                                                        $preview = trim(strip_tags(html_entity_decode($raw, ENT_QUOTES | ENT_HTML5)));
                                                        $preview = preg_replace('/\s+/', ' ', $preview); // rapikan spasi/baris ganda
                                                    @endphp

                                                    @if($preview !== '')
                                                        {{ \Illuminate\Support\Str::limit($preview, 150) }}
                                                    @elseif(str_contains($raw, '<img'))
                                                        {!! preg_replace('/<img/', '<img style="max-width:120px;max-height:80px;height:auto;" ', $raw, 1) !!}
                                                    @else
                                                        <em class="text-muted">—</em>
                                                    @endif
                                                </td>
                                                <td>{{ $question?->topic?->category }}</td>
                                                <td>{{ $question?->topic?->name }}</td>
                                                <td class="d-flex align-items-center">
                                                    <a href="{{ route('console.question.preview', $question->id) }}" target="_blank" class="btn btn-info btn-sm mr-2">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('console.tryout.question.edit', [$tryout?->id,$question->id]) }}" class="btn btn-warning btn-sm mr-2">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form class="mr-2" action="{{ route('console.tryout.question.destroy', [$tryout?->id,$question->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus question ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal pilih soal --}}
    <div class="modal fade" id="bankModal" tabindex="-1" role="dialog" aria-labelledby="bankModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <form action="{{ route('console.tryout.question.attach', $tryout->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                <h5 class="modal-title" id="bankModalLabel">Pilih Soal dari Bank Soal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    {{-- Filter Kategori & Topik --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <select id="filterCategory" class="form-control">
                                <option value="">Semua Kategori</option>
                                <option value="TWK">TWK</option>
                                <option value="TIU">TIU</option>
                                <option value="TKP">TKP</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="searchQuestion" class="form-control" placeholder="Cari soal...">
                        </div>
                    </div>

                    <div style="max-height: 400px; overflow-y:auto;">
                    @foreach($bankQuestions as $q)
                        <div class="form-check mb-2 bank-item" data-category="{{ $q->topic->category }}">
                            <input type="checkbox" name="question_ids[]" value="{{ $q->id }}" class="form-check-input">
                            <label class="form-check-label">
                                <strong>[{{ $q->topic->category }} - {{ $q->topic->name }}]</strong> 
                                {!! Str::limit(strip_tags($q->question), 120) !!}
                            </label>
                        </div>
                    @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-success">Tambahkan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
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
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        new Sortable(document.getElementById('sortable-question-list'), {
            animation: 150,
            handle: '.cursor-move', // bisa digeser dari barisnya langsung
            onEnd: function () {
                let order = [];
                document.querySelectorAll('#sortable-question-list tr').forEach((row, index) => {
                    order.push({
                        id: row.getAttribute('data-id'),
                        position: index + 1
                    });
                });

                fetch("{{ route('console.tryout.question.reorder', $tryout->id) }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ order })
                }).then(res => res.json())
                .then(data => {
                    console.log(data);
                });
            }
        });

         $('#filterCategory').on('change', function(){
            let cat = $(this).val().toLowerCase();
            $('.bank-item').each(function(){
                let itemCat = $(this).data('category').toLowerCase();
                $(this).toggle(cat === '' || itemCat === cat);
            });
        });

        $('#searchQuestion').on('keyup', function(){
            let keyword = $(this).val().toLowerCase();
            $('.bank-item').each(function(){
                let text = $(this).text().toLowerCase();
                $(this).toggle(text.includes(keyword));
            });
        });

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
        // Import 2-tahap (analyze -> review -> commit)
        // ============================
        const $importForm = $('#importForm');
        let reviewToken = null;
        let reviewExt   = null;

        $importForm.on('submit', function (e) {
            e.preventDefault();

            const fileInput = document.getElementById('importFile');
            if (!fileInput.files.length) return;

            const fd = new FormData();
            fd.append('file', fileInput.files[0]);
            fd.append('_token', '{{ csrf_token() }}');

            const $btn = $('#btnAnalyze');
            const original = $btn.html();
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Mengecek...');

            $.ajax({
                url: $importForm.data('analyze'),
                method: 'POST',
                data: fd,
                processData: false,
                contentType: false,
            }).done(function (res) {
                renderReview(res);
                $('#importReviewModal').modal('show');
            }).fail(function (xhr) {
                const msg = xhr.responseJSON?.message || 'Gagal menganalisa file.';
                alert(msg);
            }).always(function () {
                $btn.prop('disabled', false).html(original);
            });
        });

        function renderReview(res) {
            reviewToken = res.token;
            reviewExt   = res.ext;

            const s = res.summary;
            const allOk = s.failed === 0;

            $('#reviewSummary').html(
                `<div class="alert ${allOk ? 'alert-success' : 'alert-warning'} mb-0">
                    <strong>Total: ${s.total}</strong> &nbsp;|&nbsp;
                    <span class="text-success"><i class="fas fa-check-circle"></i> Lolos: ${s.ok}</span> &nbsp;|&nbsp;
                    <span class="text-danger"><i class="fas fa-times-circle"></i> Gagal: ${s.failed}</span>
                    ${allOk
                        ? '<div class="mt-1">Semua baris valid. Klik <strong>Lanjutkan Import</strong> untuk menyimpan.</div>'
                        : '<div class="mt-1">Perbaiki baris yang gagal di Excel, lalu ulangi. Tidak ada soal yang disimpan sampai semua valid.</div>'}
                 </div>`
            );

            const rows = res.rows.map(r => {
                const badge = r.status === 'ok'
                    ? '<span class="badge badge-success">OK</span>'
                    : '<span class="badge badge-danger">GAGAL</span>';
                const reason = r.reason
                    ? `<span class="text-danger">${$('<div>').text(r.reason).html()}</span>`
                    : '<span class="text-muted">—</span>';
                return `<tr class="${r.status === 'failed' ? 'table-danger' : ''}">
                            <td class="text-center">${r.row}</td>
                            <td class="text-center">${r.number}</td>
                            <td>${$('<div>').text(r.label).html()}</td>
                            <td class="text-center">${badge}</td>
                            <td>${reason}</td>
                        </tr>`;
            }).join('');

            $('#reviewTableBody').html(rows);

            // Tombol commit hanya muncul kalau SEMUA lolos (all-or-nothing)
            $('#btnCommitImport').toggle(allOk);
        }

        $('#btnCommitImport').on('click', function () {
            if (!reviewToken) return;

            const $btn = $(this);
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');

            $.ajax({
                url: $importForm.data('commit'),
                method: 'POST',
                data: { _token: '{{ csrf_token() }}', token: reviewToken, ext: reviewExt },
            }).done(function (res) {
                location.reload();
            }).fail(function (xhr) {
                const msg = xhr.responseJSON?.message || 'Import gagal.';
                alert(msg);
                $btn.prop('disabled', false).html('<i class="fas fa-check mr-1"></i> Lanjutkan Import');
            });
        });
    </script>
@endpush