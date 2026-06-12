@extends('backend.layout.app')
@section('content')
    @include('backend.layout.breadcrumb',['content' => 'Edit Tryout Source'])
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Edit Source</h3>
                        </div>
                        <form method="POST" action="{{ route('console.tryout-source.update', $source->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="sourceName">Nama Source</label>
                                    <input type="text" name="name" id="sourceName"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', $source->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="fas fa-save mr-1"></i> Simpan
                                </button>
                                <a href="{{ route('console.tryout-source.index') }}" class="btn btn-secondary">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection