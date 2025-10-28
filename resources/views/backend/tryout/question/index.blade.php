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
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title mb-0">
                                <strong>Total Soal : {{ $questions->count() }}</strong>
                            </h3>
                            <a href ="{{ route('console.tryout.question.create',$tryout->id) }}" type="button" class="btn btn-primary btn-sm ml-auto">
                                <strong>
                                    <i class="fas fa-plus fa-fw mr-1"></i> 
                                    <span style="letter-spacing: 0.05em;">CREATE</span>
                                </strong>
                            </a>
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
    </script>
@endpush