@extends('backend.layout.app')
@section('content')
    @include('backend.layout.breadcrumb',['content' => 'Settings'])
    <div class="content">
        <div class="container-fluid">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title mb-0">Settings</h3>
                            <button type="button" class="btn btn-primary btn-sm ml-auto" data-toggle="modal" data-target="#createModal">
                                <strong>
                                    <i class="fas fa-plus fa-fw mr-1"></i>
                                    <span style="letter-spacing: 0.05em;">CREATE</span>
                                </strong>
                            </button>
                        </div>

                        <div class="card-body table-responsive p-0" style="height: 700px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Key</th>
                                        <th>Value</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($settings->count())
                                        @foreach ($settings as $setting)
                                            <tr class="align-middle">
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-bold">{{ $setting?->key ?? '-' }}</td>
                                                <td>{{ $setting?->value ?? '-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($setting?->updated_at)->translatedFormat('d F Y | h:i') }}</td>
                                                <td class="d-flex align-items-center">
                                                    <button type="button" class="btn btn-warning btn-sm mr-2 btn-edit"
                                                        data-id="{{ $setting->id }}"
                                                        data-key="{{ $setting->key }}"
                                                        data-value="{{ $setting->value }}"
                                                        data-toggle="modal" data-target="#editModal">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('console.setting.destroy', $setting->id) }}" method="POST" onsubmit="return confirm('Hati-hati! Setting ini mungkin dipakai di kode (harga, passing grade, dll). Menghapusnya bisa bikin fitur error. Yakin tetap hapus?');">
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

    <!-- Modal Create -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('console.setting.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Setting</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="create-key">Key</label>
                            <input type="text" name="key" id="create-key" class="form-control" placeholder="contoh: package_price" required>
                            <small class="form-text text-muted">Huruf kecil, angka, underscore.</small>
                        </div>
                        <div class="form-group">
                            <label for="create-value">Value</label>
                            <textarea name="value" id="create-value" rows="2" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('console.setting.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="edit-id">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Setting</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Key</label>
                            <input type="text" id="edit-key" class="form-control" disabled>
                            <small class="form-text text-muted">Key tidak bisa diubah. Hapus lalu buat baru jika perlu.</small>
                        </div>
                        <div class="form-group">
                            <label for="edit-value">Value</label>
                            <textarea name="value" id="edit-value" rows="2" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js-bottom')
    <script>
        $('.btn-edit').on('click', function () {
            $('#edit-id').val($(this).data('id'));
            $('#edit-key').val($(this).data('key'));
            $('#edit-value').val($(this).data('value'));
        });
    </script>
@endpush