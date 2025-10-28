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

                            {{-- Import Form (1 baris) --}}
                            <form action="{{ route('console.tryout.question.import', $tryout->id) }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2 flex-wrap">
                                @csrf
                                <div class="input-group">
                                    <div class="custom-file mr-2">
                                        <input type="file" name="file" id="importFile" class="custom-file-input" required>
                                        <label class="custom-file-label" for="importFile">
                                            <i class="fas fa-file-excel mr-2"></i> Pilih File Excel...
                                        </label>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary d-flex align-items-center shadow-sm" type="submit">
                                            <i class="fas fa-upload mr-2"></i> Import
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
                                                <td>{!! Str::limit(strip_tags($question?->question), 100) !!}</td>
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
    </script>
@endpush