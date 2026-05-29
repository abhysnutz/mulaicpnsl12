@extends('backend.layout.app')
@section('content')
    @include('backend.layout.breadcrumb',['content' => 'User'])

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar User</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            @if(session('success'))
                                <div class="alert alert-success m-3">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <table class="table table-head-fixed table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Expire Subscribe</th>
                                        <th>Status Akun</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($users->count())
                                        @foreach ($users as $user)
                                            <tr class="align-middle">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user?->name }}</td>
                                                <td>{{ $user?->email }}</td>
                                                <td class="text-capitalize text-bold">{{ $user?->subscription_status }}</td>
                                                <td>
                                                    @if ($user?->subscription_status == 'free')
                                                        -
                                                    @else
                                                        {{ \Carbon\Carbon::parse($user?->subscription?->end_date)->translatedFormat('d F Y') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($user?->is_suspended)
                                                        <span class="badge badge-danger"
                                                              title="{{ $user?->suspension_reason }}">Suspended</span>
                                                    @else
                                                        <span class="badge badge-success">Aktif</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($user?->is_suspended)
                                                        <form action="{{ route('console.user.unsuspend', $user->id) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('Buka suspend untuk {{ $user?->name }}?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                Buka Suspend
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                                data-toggle="modal"
                                                                data-target="#suspendModal{{ $user->id }}">
                                                            Suspend
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal konfirmasi suspend (di luar tabel biar tidak ke-clip) --}}
    @if ($users->count())
        @foreach ($users as $user)
            @if (!$user?->is_suspended)
                <div class="modal fade" id="suspendModal{{ $user->id }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form action="{{ route('console.user.suspend', $user->id) }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Suspend Akun: {{ $user?->name }}</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-muted">Email: {{ $user?->email }}</p>
                                    <div class="form-group">
                                        <label>Alasan Suspend <span class="text-danger">*</span></label>
                                        <textarea name="reason" class="form-control" rows="3"
                                                  placeholder="Contoh: Terdeteksi akun digunakan di banyak lokasi berbeda"
                                                  required maxlength="255"></textarea>
                                        <small class="text-muted">Alasan ini akan ditampilkan ke user saat mencoba login.</small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Ya, Suspend</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
@endsection