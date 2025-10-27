@extends('backend.layout.app')
@section('content')
    @include('backend.layout.breadcrumb',['content' => $tryout?->title.' | Question' ])
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title mb-0">Bordered Table</h3>
                            <a href ="{{ route('console.tryout.question.create',$tryout->id) }}" type="button" class="btn btn-primary btn-sm ml-auto">
                                <strong>
                                    <i class="fas fa-plus fa-fw mr-1"></i> 
                                    <span style="letter-spacing: 0.05em;">CREATE</span>
                                </strong>
                            </a>
                        </div>

                        <div class="card-body table-responsive p-0" style="height: 450px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">No</th>
                                        <th>Soal</th>
                                        <th>Kategori</th>
                                        <th>Topik</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($questions->count())
                                        @foreach ($questions as $question)
                                            <tr class="align-middle">
                                                <td>{{ $question?->pivot?->order }}</td>
                                                <td>{!! $question?->question !!}</td>
                                                <td>{{ $question?->topic?->category }}</td>
                                                <td>{{ $question?->topic?->name }}</td>
                                                <td class="d-flex align-items-center">
                                                    <a href="{{ route('console.tryout.question.edit', [$tryout?->id,$question->id]) }}" class="btn btn-warning btn-sm mr-2">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form class="mr-2" action="{{ route('console.tryout.question.destroy', [$tryout?->id,$question->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus question ini?');">
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
@endsection