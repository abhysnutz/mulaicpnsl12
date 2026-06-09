@extends('backend.layout.app')
@section('content')
    @include('backend.layout.breadcrumb',['content' => 'Komisi Referral'])
    <div class="app-content">
        <div class="container-fluid">

            {{-- Ringkasan --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>Rp {{ number_format($totalKomisiKeseluruhan, 0, ',', '.') }}</h3>
                            <p>Total Komisi Keseluruhan</p>
                        </div>
                        <span class="small-box-icon"><i class="fas fa-coins"></i></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box text-bg-info">
                        <div class="inner">
                            <h3>{{ $topReferrers->count() }}</h3>
                            <p>Jumlah Pengajak Aktif</p>
                        </div>
                        <span class="small-box-icon"><i class="fas fa-user-friends"></i></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>{{ $commissions->count() }}</h3>
                            <p>Total Transaksi Komisi</p>
                        </div>
                        <span class="small-box-icon"><i class="fas fa-receipt"></i></span>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- Rekap per pengajak --}}
                <div class="col-md-5">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Peringkat Pengajak</h3>
                        </div>
                        <div class="card-body table-responsive p-0" style="max-height: 500px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Pengajak</th>
                                        <th>Orang Diajak</th>
                                        <th>Total Komisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($topReferrers as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row?->referrer?->name ?? '-' }}</td>
                                            <td>{{ $row->total_transaksi }}</td>
                                            <td class="text-bold">Rp {{ number_format($row->total_komisi, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center text-muted">Belum ada komisi.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Riwayat komisi --}}
                <div class="col-md-7">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Riwayat Komisi</h3>
                        </div>
                        <div class="card-body table-responsive p-0" style="max-height: 500px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Tanggal</th>
                                        <th>Pengajak</th>
                                        <th>Diajak (Yang Bayar)</th>
                                        <th>Komisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($commissions as $commission)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($commission?->created_at)->format('d-M-Y H:i') }}</td>
                                            <td>{{ $commission?->referrer?->name ?? '-' }}</td>
                                            <td>{{ $commission?->referee?->name ?? '-' }}</td>
                                            <td class="text-bold">Rp {{ number_format($commission?->amount ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center text-muted">Belum ada komisi.</td></tr>
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