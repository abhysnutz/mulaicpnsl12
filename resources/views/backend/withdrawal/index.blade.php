@extends('backend.layout.app')
@section('content')
    @include('backend.layout.breadcrumb',['content' => 'Penarikan Saldo'])
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Permintaan Penarikan</h3>
                        </div>
                        <div class="card-body table-responsive p-0" style="max-height: 500px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Tanggal</th>
                                        <th>Rekening Tujuan</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Catatan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($withdrawals->count())
                                        @foreach ($withdrawals as $withdrawal)
                                            <tr class="align-middle">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $withdrawal?->user?->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($withdrawal?->created_at)->format('d-M-Y H:i') }}</td>
                                                <td>
                                                    <div><span class="text-bold">{{ $withdrawal?->bank_name }}</span></div>
                                                    <div>No. Rekening: <span class="text-bold">{{ $withdrawal?->account_number }}</span></div>
                                                    <div>Nama: <span class="text-bold">{{ $withdrawal?->account_name }}</span></div>
                                                </td>
                                                <td class="px-6 py-4 text-bold">Rp {{ number_format($withdrawal?->amount ?? 0, 0, ',', '.') }}</td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2 py-2 text-sm badge @if($withdrawal?->status == 'pending') text-bg-warning @elseif($withdrawal?->status == 'approved') text-bg-success @else text-bg-danger @endif text-capitalize">{{ $withdrawal?->status }}</span>
                                                </td>
                                                <td>{{ $withdrawal?->admin_note ?? '-' }}</td>
                                                <td>
                                                    @if ($withdrawal?->status == 'pending')
                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#approveModal{{ $withdrawal->id }}">Setujui</button><br>
                                                        <button type="button" class="btn btn-danger btn-sm mt-2" data-toggle="modal" data-target="#rejectModal{{ $withdrawal->id }}">Tolak</button>
                                                    @endif
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

    {{-- Modal di luar tabel biar tidak ke-clip --}}
    @if ($withdrawals->count())
        @foreach ($withdrawals as $withdrawal)
            @if ($withdrawal?->status == 'pending')

                {{-- APPROVE --}}
                <div class="modal fade" id="approveModal{{ $withdrawal->id }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form action="{{ route('console.withdrawal.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $withdrawal->id }}">
                            <input type="hidden" name="status" value="approved">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Setujui Penarikan: {{ $withdrawal?->user?->name }}</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-muted mb-2">Pastikan Anda sudah transfer manual ke rekening berikut sebelum menyetujui:</p>
                                    <ul class="mb-3">
                                        <li>Bank: <strong>{{ $withdrawal?->bank_name }}</strong></li>
                                        <li>No. Rekening: <strong>{{ $withdrawal?->account_number }}</strong></li>
                                        <li>Atas Nama: <strong>{{ $withdrawal?->account_name }}</strong></li>
                                        <li>Jumlah: <strong>Rp {{ number_format($withdrawal?->amount ?? 0, 0, ',', '.') }}</strong></li>
                                    </ul>
                                    <div class="alert alert-warning py-2">Menyetujui akan <strong>memotong saldo</strong> user sebesar jumlah di atas.</div>
                                    <div class="form-group">
                                        <label>Catatan (opsional)</label>
                                        <input type="text" name="admin_note" class="form-control" maxlength="255" placeholder="Contoh: Sudah ditransfer 12:30">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success">Ya, Setujui & Potong Saldo</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- REJECT --}}
                <div class="modal fade" id="rejectModal{{ $withdrawal->id }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form action="{{ route('console.withdrawal.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $withdrawal->id }}">
                            <input type="hidden" name="status" value="rejected">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tolak Penarikan: {{ $withdrawal?->user?->name }}</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-muted">Menolak <strong>tidak memotong saldo</strong>. Saldo user tetap utuh.</p>
                                    <div class="form-group">
                                        <label>Alasan Penolakan (opsional)</label>
                                        <textarea name="admin_note" class="form-control" rows="3" maxlength="255" placeholder="Contoh: Data rekening tidak valid"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Ya, Tolak</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            @endif
        @endforeach
    @endif
@endsection