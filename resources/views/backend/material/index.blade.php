@extends('backend.layout.app')

@section('content')
    @include('backend.layout.breadcrumb', ['content' => 'Materi'])
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif

                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title mb-0">
                                Manajemen Materi
                                <span class="badge badge-info ml-2">{{ $materials->count() }} materi</span>
                            </h3>
                            <a href="{{ route('console.material.create') }}" class="btn btn-primary btn-sm ml-auto">
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
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Topik</th>
                                        <th>File</th>
                                        <th>Ukuran</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($materials as $material)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $material->title }}</td>
                                            <td>{{ $material->topic?->category }}</td>
                                            <td>{{ $material->topic?->name }}</td>
                                            <td>{{ Str::limit($material->original_name, 30) }}</td>
                                            <td>{{ $material->readable_size }}</td>
                                            <td>
                                                @if ($material->is_active)
                                                    <span class="badge badge-success">Aktif</span>
                                                @else
                                                    <span class="badge badge-secondary">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td class="d-flex align-items-center">
                                                <a href="{{ route('console.material.edit', $material->id) }}" class="btn btn-warning btn-sm mr-2">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form class="mr-2" action="{{ route('console.material.destroy', $material->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus materi ini? File PDF juga ikut terhapus.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                Belum ada materi. Klik CREATE untuk menambah.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection