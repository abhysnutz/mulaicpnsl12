@extends('backend.layout.app')
@section('content')
    @include('backend.layout.breadcrumb',['content' => 'Create Tryout'])

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">
                    <div class="container mt-4">
                        <form action="{{ route('console.tryout.store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label for="title" class="col-sm-2 col-form-label text-end">Judul</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                            </div>
                    
                            <div class="row mb-3">
                                <label for="category" class="col-sm-2 col-form-label text-end">Kategori</label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="Tryout">Tryout</option>
                                        <option value="Latihan TWK">Latihan TWK</option>
                                        <option value="Latihan TIU">Latihan TIU</option>
                                        <option value="Latihan TKP">Latihan TKP</option>
                                    </select>
                                </div>
                            </div>
                    
                            <div class="row mb-3">
                                <label for="source" class="col-sm-2 col-form-label text-end">Sumber Tryout</label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="source" name="tryout_source_id">
                                        @foreach ($sources as $source)
                                            <option value="{{ $source?->id }}">{{ $source?->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    
                            <div class="row mb-3">
                                <label for="duration" class="col-sm-2 col-form-label text-end">Durasi (Menit)</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" id="duration" name="duration" required value="100">
                                </div>
                            </div>
                    
                            <div class="row mb-3">
                                <label for="access_type" class="col-sm-2 col-form-label text-end">Tipe Akses</label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="access_type" name="access_type" required>
                                        <option value="free">Gratis</option>
                                        <option value="premium">Premium</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="status" class="col-sm-2 col-form-label text-end">Status</label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="draft">Draft / Pending</option>
                                        <option value="publish">Publish</option>
                                        <option value="archived">Arsipkan</option>
                                    </select>
                                </div>
                            </div>
                    
                            <div class="row">
                                <div class="col-sm-2"></div> <!-- Spasi agar tombol sejajar -->
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
