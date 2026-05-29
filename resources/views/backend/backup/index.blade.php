@extends('backend.layout.app')
@section('content')
    @include('backend.layout.breadcrumb',['content' => 'Database Backup' ])
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    {{-- Export & Upload Bar --}}
                    <div class="card-body border-bottom pb-3">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">

                            {{-- Export & Fresh Migrate --}}
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('console.backup.export') }}" class="btn btn-success d-flex align-items-center shadow-sm mr-2">
                                    <i class="fas fa-database mr-2"></i> Export Now
                                </a>

                                <form action="{{ route('console.backup.migrate-fresh') }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('⚠️ PERINGATAN KERAS: Semua tabel akan di-DROP, di-CREATE ulang dari migration, dan seeder akan dijalankan.\n\nSEMUA DATA AKAN HILANG.\n\nLanjutkan?');">
                                    @csrf
                                    <button type="submit" class="btn btn-danger d-flex align-items-center shadow-sm">
                                        <i class="fas fa-redo-alt mr-2"></i> Fresh Migrate & Seed
                                    </button>
                                </form>
                            </div>

                            {{-- Upload Form --}}
                            <form action="{{ route('console.backup.upload') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2 flex-wrap">
                                @csrf
                                <div class="input-group">
                                    <div class="custom-file mr-2">
                                        <input type="file" name="file" id="uploadFile" class="custom-file-input" accept=".sql,.gz" required>
                                        <label class="custom-file-label" for="uploadFile">
                                            <i class="fas fa-file-archive mr-2"></i> Pilih File Backup...
                                        </label>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary d-flex align-items-center shadow-sm" type="submit">
                                            <i class="fas fa-upload mr-2"></i> Upload
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Backup List</h3>
                        </div>

                        <div class="card-body table-responsive p-0" style="height: 450px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">No</th>
                                        <th>Filename</th>
                                        <th>Size</th>
                                        <th>Created</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($backups->count())
                                        @foreach ($backups as $backup)
                                            <tr class="align-middle">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $backup->name }}</td>
                                                <td>{{ $backup->size }}</td>
                                                <td>{{ $backup->created_at }}</td>
                                                <td>
                                                    @if(str_starts_with($backup->name, 'uploaded_'))
                                                        <span class="badge text-bg-info">Uploaded</span>
                                                    @else
                                                        <span class="badge text-bg-success">Manual Export</span>
                                                    @endif
                                                </td>
                                                <td class="d-flex align-items-center">
                                                    <a href="{{ route('console.backup.download', $backup->name) }}" class="btn btn-info btn-sm mr-2" title="Download">
                                                        <i class="fas fa-download"></i>
                                                    </a>

                                                    <form action="{{ route('console.backup.import', $backup->name) }}" method="POST" class="mr-2"
                                                          onsubmit="return confirm('⚠️ PERINGATAN: Database akan di-OVERWRITE dengan data dari file ini. Semua data saat ini akan hilang. Lanjutkan?');">
                                                        @csrf
                                                        <button type="submit" class="btn btn-warning btn-sm" title="Import">
                                                            <i class="fas fa-file-import"></i>
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('console.backup.destroy', $backup->name) }}" method="POST"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus backup ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                Belum ada backup. Klik "Export Now" untuk membuat backup pertama.
                                            </td>
                                        </tr>
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
    <script>
        // Ganti label saat pilih file
        document.querySelector('.custom-file-input').addEventListener('change', function (e) {
            const fileName = e.target.files[0].name;
            e.target.nextElementSibling.innerText = fileName;
        });
    </script>
@endpush