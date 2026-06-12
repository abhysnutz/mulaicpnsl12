@extends('backend.layout.app')
@section('content')
    @include('backend.layout.breadcrumb',['content' => 'Tryout Source'])
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    {{-- Form tambah source --}}
                    <div class="card mb-3">
                        <div class="card-body py-3">
                            <form method="POST" action="{{ route('console.tryout-source.store') }}" class="form-row align-items-end">
                                @csrf
                                <div class="form-group col-md-5 mb-2 mb-md-0">
                                    <label for="sourceName">Nama Source Baru</label>
                                    <input type="text" name="name" id="sourceName"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Contoh: ayocpns.com" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3 mb-0">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-plus mr-1"></i> Tambah
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Tabel source --}}
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title mb-0">
                                Tryout Source Management
                                <span class="badge badge-info ml-2">{{ $sources->count() }} source</span>
                            </h3>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">No</th>
                                        <th>Nama</th>
                                        <th>Dipakai Tryout</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($sources as $source)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $source->name }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $source->tryouts_count }}</span>
                                            </td>
                                            <td class="d-flex align-items-center">
                                                <a href="{{ route('console.tryout-source.edit', $source->id) }}" class="btn btn-warning btn-sm mr-2">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('console.tryout-source.destroy', $source->id) }}" method="POST"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus source ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                            {{ $source->tryouts_count > 0 ? 'disabled title=Source masih dipakai tryout' : '' }}>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">
                                                Belum ada source. Tambahkan lewat form di atas.
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