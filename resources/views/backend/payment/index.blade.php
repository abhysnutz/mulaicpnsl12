@extends('backend.layout.app')
@section('content')
    @include('backend.layout.breadcrumb',['content' => 'Payment'])
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Bordered Table</h3>
                        </div>
                        <div class="card-body">

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Tanggal</th>
                                        <th>Rekening / No Tujuan</th>
                                        <th>Jumlah</th>
                                        <th>Whatsapp</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($payments->count())
                                        @foreach ($payments as $payment)
                                            <tr class="align-middle">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $payment?->user?->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($payment?->created_at)->format('d-M-Y H:i') }}</td>
                                                <td>
                                                    <div> <span class="text-bold">{{ $payment?->method?->name }}</span></div>
                                                    <div>No. Rekening: <span class="text-bold">{{ $payment?->method?->account_number }}</span></div>
                                                    <div>Nama: <span class="text-bold">{{ $payment?->method?->account_name }}</span></div>
                                                </td>
                                                <td class="px-6 py-4 text-bold">{{ $payment?->total ?? 0}}</td>
                                                <td class="px-6 py-4 text-bold">{{ $payment?->whatsapp ?? 0}}</td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2 py-2 text-sm badge @if($payment?->status == 'pending') text-bg-warning @elseif($payment?->status == 'confirmed') text-bg-success @else text-bg-danger @endif text-capitalize">{{ $payment?->status }}</span>
                                                </td>
                                                <td>
                                                    @if ($payment?->status == 'pending')
                                                        <form action="{{ route('console.payment.update') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $payment->id }}">
                                                            
                                                            <button type="submit" name="status" value="confirmed" class="btn btn-success btn-sm">Confirmed</button><br>
                                                            <button type="submit" name="status" value="rejected" class="btn btn-danger btn-sm mt-2">Rejected</button>    
                                                        </form>
                                                    @endif
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-end">
                                <li class="page-item">
                                    <a class="page-link" href="#">&laquo;</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">&raquo;</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection