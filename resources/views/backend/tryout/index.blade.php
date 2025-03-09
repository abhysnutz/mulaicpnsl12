@extends('backend.layout.app')
@section('content')
    @include('backend.layout.breadcrumb',['content' => 'Tryout'])
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title mb-0">Bordered Table</h3>
                            <a href ="{{ route('console.tryout.create') }}" type="button" class="btn btn-primary btn-sm ml-auto">
                                <strong>
                                    <i class="fas fa-plus fa-fw mr-1"></i> 
                                    <span style="letter-spacing: 0.05em;">CREATE</span>
                                </strong>
                            </a>
                        </div>

                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Category</th>
                                        <th>Source</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                        <th>Update Question</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($tryouts->count())
                                        @foreach ($tryouts as $tryout)
                                            <tr class="align-middle">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $tryout?->title ?? '-' }}</td>
                                                <td>{{ $tryout?->access_type ?? '-' }}</td>
                                                <td>{{ $tryout?->category ?? '-' }}</td>
                                                <td>{{ $tryout?->source?->name ?? '-' }}</td>
                                                <td>{{ $tryout?->status ?? '-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($tryout?->created_at)->translatedFormat('d F Y | h:i') }}</td>
                                                <td class="d-flex align-items-center">
                                                    <a href="{{ route('console.tryout.edit', $tryout?->id) }}" class="btn btn-warning btn-sm mr-2">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('console.tryout.destroy', $tryout->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tryout ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-info btn-sm ms-auto me-2">
                                                        <strong> <span style="letter-spacing: 0.05em;">QUESTION</span> </strong>
                                                    </button>
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