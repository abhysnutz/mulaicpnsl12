@extends('backend.layout.app')
@section('content')
    @include('backend.layout.breadcrumb',['content' => 'User'])

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bordered Table</h3>
                        </div>
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Expire Subscribe</th>
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
@endsection