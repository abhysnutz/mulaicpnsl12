@extends('backend.layout.app')
@section('content')
    @include('backend.layout.breadcrumb',['content' => 'Dashboard'])

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
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection