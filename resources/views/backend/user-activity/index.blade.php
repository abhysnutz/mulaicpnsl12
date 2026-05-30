@extends('backend.layout.app')
@section('content')
    @include('backend.layout.breadcrumb', ['content' => 'User Activity'])

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Log Aktivitas User</h3>
                </div>

                <div class="card-body">
                    {{-- Filter --}}
                    <form method="GET" class="form-inline mb-3">
                        <select name="type" class="form-control mr-2">
                            <option value="">Semua Jenis</option>
                            <option value="login" {{ request('type') == 'login' ? 'selected' : '' }}>Login Berhasil</option>
                            <option value="login_failed" {{ request('type') == 'login_failed' ? 'selected' : '' }}>Login Gagal</option>
                        </select>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="form-control mr-2" placeholder="Cari email / IP">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        @if(request()->hasAny(['type', 'search']))
                            <a href="{{ route('console.user-activity.index') }}" class="btn btn-secondary ml-2">Reset</a>
                        @endif
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>User</th>
                                    <th>Aktivitas</th>
                                    <th>IP</th>
                                    <th>Perangkat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($activities as $activity)
                                    <tr>
                                        <td>{{ $activity->created_at->translatedFormat('d M Y, H:i') }}</td>
                                        <td>
                                            {{ $activity->user?->name ?? '—' }}<br>
                                            <small class="text-muted">{{ $activity->properties['email'] ?? $activity->user?->email }}</small>
                                        </td>
                                        <td>
                                            @if ($activity->type === 'login')
                                                <span class="badge badge-success">{{ $activity->description }}</span>
                                            @elseif ($activity->type === 'login_failed')
                                                <span class="badge badge-danger">{{ $activity->description }}</span>
                                            @else
                                                <span class="badge badge-info">{{ $activity->description ?? $activity->type }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $activity->ip_address ?? '—' }}</td>
                                        <td>{{ $activity->device_label }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada aktivitas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-3">
                        {{ $activities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection