@extends('frontend.layout')
@section('content')
<div class="pt-4 pb-20 sm:pt-6 sm:pb-6">
    <div class="mx-auto px-4 sm:px-6 md:px-5">
        <div class="bg-white px-5 pt-5 pb-8 rounded-lg">
            @include('frontend.breadcrumb', ['content' => 'Statistik'])
            <div>
                <div id="tryout" class="w-full flex flex-col my-4">
                    <div class="flex items-center w-full mb-4">
                        <h5 class="text-lg font-semibold min-w-min w-2/12"> Tryout </h5>
                        <p class="text-base sm:w-6/12 w-full ml-2 sm:ml-2"> {{ $exam?->tryout?->title }}</p>
                    </div>
                    <div>
                        <div>
                            <div class="border-b border-gray-200">
                                <nav aria-label="Tabs" class="-mb-px flex space-x-8">
                                    <a href="#" class="group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm border-indigo-500 text-indigo-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="-ml-0.5 mr-2 h-5 w-5 text-indigo-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 13v-1m4 1v-3m4 3V8M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                        </svg>
                                        <span>Statistik</span>
                                    </a>
                                    <a href="{{ route('tryout.result.explanation', $exam->id) }}" class="group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="-ml-0.5 mr-2 h-5 w-5 text-gray-400 group-hover:text-gray-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                        <span>Pembahasan</span>
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div id="pills-tabContent-custom" class="tab-content">
                        <div id="tab-statistik" role="tabpanel" aria-labelledby="pills-profile-tab-custom" class="tab-pane fade active show">
                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <div id="statistik" class="my-6">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900"> Statistik </h3>
                                        <div class="grid gap-2  mx-auto xl:grid-cols-2 sm:grid-cols-1 xl:w-full">
                                            <dl class="w-full mx-auto mt-5 rounded-lg bg-white overflow-hidden border border-gray-300 hover:bg-gray-50 divide-y divide-gray-200 md:divide-y-0 md:divide-x">
                                                <div class="px-4 py-5 sm:p-6 col-span-3">
                                                    <dt class="text-xl font-medium text-gray-900 text-center mb-4"> SKOR AKHIR </dt>
                                                    <div class="text-6xl font-semibold text-indigo-600 text-center"> {{ $exam?->result?->total_score }} <span class="ml-0 text-3xl font-medium text-gray-500"> dari <strong>550</strong>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <dt class="text-xl font-medium text-gray-900 text-center mb-4 mt-8"> Keterangan </dt>
                                                        <div class="text-center">
                                                            @if($exam?->result?->is_passed)
                                                                <span class="inline-flex items-center px-8 py-2 rounded-lg border border-green-500 text-sm font-medium bg-green-200 text-green-800">
                                                                    LULUS
                                                                </span>
                                                            @else
                                                                <span class="inline-flex items-center px-8 py-2 rounded-lg border border-red-500 text-sm font-medium bg-red-200 text-red-800">
                                                                    TIDAK LULUS
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </dl>
                                            <dl class="w-full mx-auto mt-5 rounded-lg overflow-hidden divide-y divide-gray-200 md:divide-y-0 md:divide-x">
                                                <div class="w-full flex space-x-2 md:overflow-visible overflow-scroll">
                                                    <div class="border border-gray-300 rounded-lg py-2 w-full">
                                                        <div class="w-full text-center p-1 h-8">
                                                            <p class="text-white font-medium sm:text-lg text-base"></p>
                                                        </div>
                                                        <div class="w-full h-4 overflow-hidden"></div>
                                                        <div class="bg-blue-100 text-right px-2 my-1.5">
                                                            <p class="text-gray-800 sm:text-lg text-base font-medium"> Nilai </p>
                                                        </div>
                                                        <div class="bg-blue-100 text-right px-2 my-1.5">
                                                            <p class="text-gray-800 sm:text-lg text-base font-medium"> Passing&nbsp;Grade </p>
                                                        </div>
                                                        <div class="bg-blue-100 text-right px-2 my-1.5">
                                                            <p class="text-gray-800 sm:text-lg text-base font-medium"> Lulus </p>
                                                        </div>
                                                    </div>
                                                    <div class="border border-gray-300 rounded-lg py-2 w-full">
                                                        <div class="w-full text-center bg-gray-500 py-1 px-3 @if($exam?->result?->total_twk >= $data['passing_grade_twk']) bg-green-500 @else bg-red-500 @endif">
                                                            <p class="text-white font-medium text-base"> TWK </p>
                                                        </div>
                                                        <div class="w-full h-4 overflow-hidden">
                                                            <div class="w-4 h-4 transform rotate-45 mx-auto -mt-2 @if($exam?->result?->total_twk >= $data['passing_grade_twk']) bg-green-500 @else bg-red-500 @endif"></div>
                                                        </div>
                                                        <div class="bg-blue-100 text-center my-1.5">
                                                            <p class="sm:text-lg text-base font-medium @if($exam?->result?->total_twk >= $data['passing_grade_twk']) text-green-500 @else text-red-500 @endif"> {{ $exam?->result?->total_twk }} </p>
                                                        </div>
                                                        <div class="bg-blue-100 text-center my-1.5">
                                                            <p class="text-gray-800 sm:text-lg text-base font-medium"> {{ $data['passing_grade_twk'] ?? '65' }} </p>
                                                        </div>
                                                        <div class="text-center my-1.5">
                                                            @if($exam?->result?->total_twk >= $data['passing_grade_twk']) 
                                                                <svg x-description="Heroicon name: solid/check-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="mx-auto h-6 w-6 text-green-400">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                                </svg>
                                                            @else 
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 text-red-400 mx-auto">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                                </svg>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="border border-gray-300 rounded-lg py-2 w-full">
                                                        <div class="w-full text-center bg-gray-500 py-1 px-3 @if($exam?->result?->total_tiu >= $data['passing_grade_tiu']) bg-green-500 @else bg-red-500 @endif">
                                                            <p class="text-white font-medium text-base"> TIU </p>
                                                        </div>
                                                        <div class="w-full h-4 overflow-hidden">
                                                            <div class="w-4 h-4 transform rotate-45 mx-auto -mt-2 @if($exam?->result?->total_tiu >= $data['passing_grade_tiu']) bg-green-500 @else bg-red-500 @endif"></div>
                                                        </div>
                                                        <div class="bg-blue-100 text-center my-1.5">
                                                            <p class="sm:text-lg text-base font-medium @if($exam?->result?->total_tiu >= $data['passing_grade_tiu']) text-green-500 @else text-red-500 @endif"> {{ $exam?->result?->total_tiu }} </p>
                                                        </div>
                                                        <div class="bg-blue-100 text-center my-1.5">
                                                            <p class="text-gray-800 sm:text-lg text-base font-medium"> {{ $data['passing_grade_tiu'] ?? '80' }} </p>
                                                        </div>
                                                        <div class="text-center my-1.5">
                                                            @if($exam?->result?->total_tiu >= $data['passing_grade_tiu']) 
                                                                <svg x-description="Heroicon name: solid/check-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="mx-auto h-6 w-6 text-green-400">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                                </svg>
                                                            @else 
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 text-red-400 mx-auto">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                                </svg>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="border border-gray-300 rounded-lg py-2 w-full">
                                                        <div class="w-full text-center bg-gray-500 py-1 px-3 @if($exam?->result?->total_tkp >= $data['passing_grade_tkp']) bg-green-500 @else bg-red-500 @endif">
                                                            <p class="text-white font-medium text-base"> TKP </p>
                                                        </div>
                                                        <div class="w-full h-4 overflow-hidden">
                                                            <div class="w-4 h-4 transform rotate-45 mx-auto -mt-2 @if($exam?->result?->total_tkp >= $data['passing_grade_tkp']) bg-green-500 @else bg-red-500 @endif"></div>
                                                        </div>
                                                        <div class="bg-blue-100 text-center my-1.5">
                                                            <p class="sm:text-lg text-base font-medium @if($exam?->result?->total_tkp >= $data['passing_grade_tkp']) text-green-500 @else text-red-500 @endif"> {{ $exam?->result?->total_tkp }} </p>
                                                        </div>
                                                        <div class="bg-blue-100 text-center my-1.5">
                                                            <p class="text-gray-800 sm:text-lg text-base font-medium"> {{ $data['passing_grade_tkp'] ?? '166' }} </p>
                                                        </div>
                                                        <div class="text-center my-1.5">
                                                            @if($exam?->result?->total_tkp >= $data['passing_grade_tkp']) 
                                                                <svg x-description="Heroicon name: solid/check-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="mx-auto h-6 w-6 text-green-400">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                                </svg>
                                                            @else 
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 text-red-400 mx-auto">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                                </svg>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-sm text-gray-500 mt-2 sm:hidden block"> *Scroll ke Kiri untuk melihat selengkapnya </p>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!---->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection