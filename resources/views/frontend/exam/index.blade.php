@extends('frontend.layout')
@section('content')
<div class="pt-4 pb-20 sm:pt-6 sm:pb-6">
    <div class="mx-auto px-4 sm:px-6 md:px-5">
        <div class="bg-white px-5 pt-5 pb-8 rounded-lg">
            @include('frontend.breadcrumb', ['content' => 'Hasil Tryout'])
            
            <div>
                <dl class="mt-5 mb-5">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tryout</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skor Akhir</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @if ($exams->count())
                                            @foreach ($exams as $exam)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $loop?->iteration }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-indigo-600 font-semibold sm:text-gray-500">
                                                        <a href="{{ route('tryout.result.statistic',$exam->id) }}" class="sm:no-underline underline">{{ $exam?->tryout?->title ?? '-' }}</a>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($exam->updated_at)->format('d M Y, h:i') }} WIB</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $exam?->result?->total_score }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <a href="{{ route('tryout.result.statistic',$exam->id) }}" class="text-indigo-700 hover:text-white mx-1 px-3 py-2 bg-indigo-100 hover:bg-indigo-500 rounded transition">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 sm:h-6 w-5 sm:w-6 inline-block">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                            </svg> Pembahasan
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="w-full">
                        <!---->
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection