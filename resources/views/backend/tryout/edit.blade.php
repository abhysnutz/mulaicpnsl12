@extends('backend.layout.app')
@section('content')
    @include('backend.layout.breadcrumb',['content' => 'Create Tryout'])

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">
                    <div class="container mt-4">
                        <form action="{{ route('console.tryout.update', $tryout->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                    
                            <div class="row mb-3">
                                <label for="title" class="col-sm-2 col-form-label text-end">Judul</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="title" name="title" required value="{{ old('title', $tryout?->title) }}">
                                </div>
                            </div>
                    
                            <div class="row mb-3">
                                <label for="category" class="col-sm-2 col-form-label text-end">Kategori</label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="Tryout" {{ $tryout->category == 'Tryout' ? 'selected' : '' }}>Tryout</option>
                                        <option value="Latihan TWK" {{ $tryout->category == 'Latihan TWK' ? 'selected' : '' }}>Latihan TWK</option>
                                        <option value="Latihan TIU" {{ $tryout->category == 'Latihan TIU' ? 'selected' : '' }}>Latihan TIU</option>
                                        <option value="Latihan TKP" {{ $tryout->category == 'Latihan TKP' ? 'selected' : '' }}>Latihan TKP</option>
                                    </select>
                                </div>
                            </div>
                    
                            <div class="row mb-3">
                                <label for="source" class="col-sm-2 col-form-label text-end">Sumber Tryout</label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="source" name="tryout_source_id">
                                        @foreach ($sources as $source)
                                            <option value="{{ $source->id }}" {{ $tryout->tryout_source_id == $source->id ? 'selected' : '' }}>
                                                {{ $source->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    
                            <div class="row mb-3">
                                <label for="duration" class="col-sm-2 col-form-label text-end">Durasi (Menit)</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" id="duration" name="duration" required value="{{ old('duration', $tryout->duration) }}">
                                </div>
                            </div>
                    
                            <div class="row mb-3">
                                <label for="access_type" class="col-sm-2 col-form-label text-end">Tipe Akses</label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="access_type" name="access_type" required>
                                        <option value="free" {{ $tryout->access_type == 'free' ? 'selected' : '' }}>Gratis</option>
                                        <option value="premium" {{ $tryout->access_type == 'premium' ? 'selected' : '' }}>Premium</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="status" class="col-sm-2 col-form-label text-end">Status</label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="draft" {{ $tryout->status == 'draft' ? 'selected' : '' }}>Draft / Pending</option>
                                        <option value="publish" {{ $tryout->status == 'publish' ? 'selected' : '' }}>Publish</option>
                                        <option value="archived" {{ $tryout->status == 'archived' ? 'selected' : '' }}>Arsipkan</option>
                                    </select>
                                </div>
                            </div>
                    
                            <div class="row">
                                <div class="col-sm-2"></div> <!-- Spasi agar tombol sejajar -->
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('console.tryout.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
