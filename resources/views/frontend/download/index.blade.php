@extends('frontend.layout')
@section('content')
<div class="pt-4 pb-20 sm:pt-6 sm:pb-6">
    <div class="mx-auto px-4 sm:px-6 md:px-5">
        <div class="bg-white px-5 pt-5 pb-8 rounded-lg">
            @include('frontend.breadcrumb', ['content' => 'Materi Download'])
        </div>
    </div>
</div>
@endsection