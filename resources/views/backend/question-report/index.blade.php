@extends('backend.layout.app')
@section('content')
    @include('backend.layout.breadcrumb', ['content' => 'Laporan Soal'])
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Laporan Soal</h3>
                        </div>
                        <div class="card-body table-responsive p-0" style="max-height: 600px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Tanggal</th>
                                        <th>Soal ID</th>
                                        <th>Jenis Masalah</th>
                                        <th>Catatan</th>
                                        <th>Pelapor</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($reports->count())
                                        @foreach ($reports as $report)
                                            <tr class="align-middle">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($report->created_at)->format('d-M-Y H:i') }}</td>
                                                <td class="text-bold">#{{ $report->question_id }}</td>
                                                <td>{{ $report->type }}</td>
                                                <td style="white-space: normal; max-width: 300px;">{{ $report->note ?? '-' }}</td>
                                                <td>{{ $report?->user?->name ?? 'User' }}</td>
                                                <td>
                                                    <span class="px-2 py-2 text-sm badge @if($report->status == 'baru') text-bg-warning @else text-bg-success @endif text-capitalize">{{ $report->status }}</span>
                                                </td>
                                                <td>
                                                    @if ($report->status == 'baru')
                                                        <form action="{{ route('console.question-report.update') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $report->id }}">
                                                            <button type="submit" name="status" value="ditangani" class="btn btn-success btn-sm">Tandai Ditangani</button>
                                                        </form>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center py-4">Belum ada laporan.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection