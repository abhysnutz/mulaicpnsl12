@extends('backend.layout.app')

@section('content')
    @include('backend.layout.breadcrumb', ['content' => 'Edit Materi'])
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Edit Materi</h3>
                        </div>

                        <form action="{{ route('console.material.update', $material->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="question_topic_id">Topik <span class="text-danger">*</span></label>
                                    <select name="question_topic_id" id="question_topic_id" class="form-control @error('question_topic_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Topik --</option>
                                        @foreach ($topics as $topic)
                                            <option value="{{ $topic->id }}" {{ old('question_topic_id', $material->question_topic_id) == $topic->id ? 'selected' : '' }}>
                                                {{ $topic->category }} - {{ $topic->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('question_topic_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="title">Judul <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $material->title) }}" required>
                                    @error('title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $material->description) }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>File saat ini</label>
                                    <p class="mb-1">
                                        <i class="fas fa-file-pdf text-danger mr-1"></i>
                                        {{ $material->original_name }}
                                        <span class="text-muted">({{ $material->readable_size }})</span>
                                    </p>
                                </div>

                                <div class="form-group">
                                    <label for="file">Ganti File PDF</label>
                                    <div class="custom-file">
                                        <input type="file" name="file" id="file" class="custom-file-input @error('file') is-invalid @enderror" accept=".pdf">
                                        <label class="custom-file-label" for="file">Biarkan kosong jika tidak ganti...</label>
                                    </div>
                                    @error('file')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti file. Format PDF, maksimal 50MB.</small>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="is_active" id="is_active" class="custom-control-input" value="1" {{ old('is_active', $material->is_active) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">Aktif (tampil ke user)</label>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i> Update
                                </button>
                                <a href="{{ route('console.material.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js-bottom')
    <script>
        document.querySelector('.custom-file-input').addEventListener('change', function (e) {
            const fileName = e.target.files[0]?.name ?? 'Pilih file PDF...';
            e.target.nextElementSibling.innerText = fileName;
        });
    </script>
@endpush