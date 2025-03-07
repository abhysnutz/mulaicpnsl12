@extends('frontend.layout')
@section('content')
<div class="pt-4 pb-20 sm:pt-6 sm:pb-6">
    <div class="mx-auto px-4 sm:px-6 md:px-5">
        <div class="bg-white px-5 pt-5 pb-8 rounded-lg">
            @include('frontend.breadcrumb', ['content' => 'Pembahasan'])
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
                                    <a href="{{ route('tryout.result.statistic',$exam->id) }}" class="group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="-ml-0.5 mr-2 h-5 w-5 text-gray-400 group-hover:text-gray-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 13v-1m4 1v-3m4 3V8M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                        </svg>
                                        <span>Statistik</span>
                                    </a>
                                    <a href="#" class="group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm border-indigo-500 text-indigo-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="-ml-0.5 mr-2 h-5 w-5 text-indigo-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                        <span>Pembahasan</span>
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div id="pills-tabContent-custom" class="tab-content">
                        <!---->
                        <div id="tab-pembahasan" role="tabpanel" aria-labelledby="pills-profile-tab-custom" class="tab-pane fade active show">
                            <div>
                                <div>
                                    <div class="flex items-start flex-col lg:flex-row">
                                        <div class="w-full lg:w-4/6 2xl:w-9/12 lg:mr-5 mb-5">
                                            <div class="px-4 py-5 sm:p-6 bg-white overflow-hidden shadow-lg ring-1 ring-gray-100 rounded-lg">
                                                <div class="flex justify-between items-center">
                                                    <h3 class="text-lg font-medium"> Soal No. 
                                                        <span id="number-question"></span>
                                                        <span id="topic-question" class="inline-flex items-center px-2.5 py-0.5 ml-2 rounded-md text-sm font-bold bg-indigo-200 text-indigo-800"></span>
                                                    </h3>
                                                    <span id="answer-status" class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-bold"> SALAH </span>
                                                </div>
                                                <hr class="my-4">
                                                <div>
                                                    <div class="question">
                                                        
                                                    </div>
                                                    <div class="options py-5">
                                                        
                                                    </div>
                                                </div>
                                                <hr class="my-4">
                                                <div>
                                                    <div class="mb-3">
                                                        <h4>
                                                            <i class="mdi mdi-file-document-outline"></i>Kunci jawaban: 
                                                            <span id="answer-key" class="font-bold"> </span>
                                                        </h4>
                                                        <h4>
                                                            <i class="mdi mdi-file-document-outline"></i>Jawaban Anda: 
                                                            <span id="your-answer" class="font-bold text-red-500"> </span>
                                                        </h4>
                                                        <hr class="my-3">
                                                        <h3>
                                                            <i class="mdi mdi-file-document-outline"></i> Waktu Mengerjakan : <span class="font-bold"> 5 Detik</span>
                                                        </h3>
                                                        <hr class="my-3">
                                                        <h3 class="font-bold">
                                                            <i class="mdi mdi-file-document-outline"></i> Pembahasan
                                                        </h3>
                                                        <div>
                                                            <div class="explanation">
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="my-4">
                                                <div class="flex justify-center">
                                                    <button id="prev-button" type="button" class="flex items-center mx-2 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 mr-2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                                        </svg> Sebelumnya </button>
                                                    <button id="next-button" type="button" class="flex items-center mx-2 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-500 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"> Selanjutnya <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 ml-2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-full lg:w-2/6 2xl:w-3/12 flex flex-col">
                                            <div class="bg-white overflow-hidden shadow-lg ring-1 ring-gray-100 rounded-lg mb-5">
                                                <div class="px-4 py-5 sm:py-3 font-medium text-center"> Nomor Soal </div>
                                                <div class="flex flex-wrap px-3 py-2 justify-center">
                                                    <div id="question-number-list">
                                                        <div class="py-2 flex column justify-center mb-2">
                                                            <div class="flex justify-start items-center mr-3">
                                                                <div class="w-6 h-6 bg-gray-400 rounded mr-1"></div>
                                                                <div class="font-medium">Kosong</div>
                                                            </div>
                                                            <div class="flex justify-start items-center mr-3">
                                                                <div class="w-6 h-6 bg-green-400 rounded mr-1"></div>
                                                                <div class="font-medium">Benar</div>
                                                            </div>
                                                            <div class="flex justify-start items-center mr-3">
                                                                <div class="w-6 h-6 bg-red-400 rounded mr-1"></div>
                                                                <div class="font-medium">Salah</div>
                                                            </div>
                                                        </div>
                                                        {{-- <button disabled="disabled" class="bg-gray-200 hover:bg-indigo-400 focus:outline-none focus:ring focus:ring-blue-300 py-1.5 rounded m-1 text-center w-9 font-medium bg-indigo-400 text-white"> 1 </button>
                                                        <button class="bg-gray-200 hover:bg-indigo-400 focus:outline-none focus:ring focus:ring-blue-300 py-1.5 rounded m-1 text-center w-9 font-medium bg-red-400 text-white"> 2 </button>
                                                        <button class="bg-gray-200 hover:bg-indigo-400 focus:outline-none focus:ring focus:ring-blue-300 py-1.5 rounded m-1 text-center w-9 font-medium bg-green-400 text-white"> 3 </button>
                                                        <button class="bg-gray-200 hover:bg-indigo-400 focus:outline-none focus:ring focus:ring-blue-300 py-1.5 rounded m-1 text-center w-9 font-medium bg-green-400 text-white"> 4 </button>
                                                        <button class="bg-gray-200 hover:bg-indigo-400 focus:outline-none focus:ring focus:ring-blue-300 py-1.5 rounded m-1 text-center w-9 font-medium bg-red-400 text-white"> 5 </button>
                                                        <button class="bg-gray-200 hover:bg-indigo-400 focus:outline-none focus:ring focus:ring-blue-300 py-1.5 rounded m-1 text-center w-9 font-medium bg-red-400 text-white"> 6 </button>
                                                        <button class="bg-gray-200 hover:bg-indigo-400 focus:outline-none focus:ring focus:ring-blue-300 py-1.5 rounded m-1 text-center w-9 font-medium bg-red-400 text-white"> 7 </button>
                                                        <button class="bg-gray-200 hover:bg-indigo-400 focus:outline-none focus:ring focus:ring-blue-300 py-1.5 rounded m-1 text-center w-9 font-medium bg-red-400 text-white"> 8 </button>
                                                        <button class="bg-gray-200 hover:bg-indigo-400 focus:outline-none focus:ring focus:ring-blue-300 py-1.5 rounded m-1 text-center w-9 font-medium bg-green-400 text-white"> 9 </button>
                                                        <button class="bg-gray-200 hover:bg-indigo-400 focus:outline-none focus:ring focus:ring-blue-300 py-1.5 rounded m-1 text-center w-9 font-medium bg-green-400 text-white"> 10 </button> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js-bottom')
    <script>
        var exam_id = {{ $exam->id }}; // Ambil ID ujian dari Blade

        function allQuestion(){
            $.ajax({
                url: "{{ route('tryout.result.questions') }}",
                dataType: 'json',
                data : {
                    exam_id
                },
                success : function(reply){
                    // Generate nomor soal
                    // $('#question-number-list').empty()
                    $.each(reply.data, function(index, question) {
                        // console.log(question);
                        
                        let button = $(`<button>`)
                            .attr("data-question-id", question).attr('data-index', index)
                            .addClass("number-question-list bg-gray-200 hover:bg-indigo-400 focus:outline-none focus:ring focus:ring-blue-300 py-1.5 rounded m-1 text-center w-9 font-medium bg-gray-400 text-white")
                            .text(index + 1)
                            .on("click", function() {
                                selectedQuestion(index);
                            });
                        $('#question-number-list').append(button);
                    });
                    
                    $.each(reply.is_answers, function(index, is_answer) {
                        // console.log(is_answer);
                        if (is_answer?.is_correct === true) {
                            // Jika benar, tambahkan class bg-green-400 & text-white
                            $(`.number-question-list[data-question-id="${is_answer?.question_id}"]`).addClass(['bg-green-400', 'text-white']);
                        } else if (is_answer?.is_correct === false) {
                            // Jika salah, tambahkan class bg-red-400 & text-white
                            $(`.number-question-list[data-question-id="${is_answer?.question_id}"]`).addClass(['bg-red-400', 'text-white']);
                        } else {
                            // Jika null atau tidak ada jawaban, tambahkan class bg-gray-400
                            $(`.number-question-list[data-question-id="${is_answer?.question_id}"]`).addClass(['bg-gray-400', 'text-white']);
                        }
                    })

                    $(`.number-question-list[data-index="0"]`).prop('disabled',true).addClass('bg-indigo-400')
                }
            })
        }

        function selectedQuestion(index) {
            console.log(index);
            $(`.number-question-list`).removeClass('bg-indigo-400').prop('disabled',false)
            $.ajax({
                url: "{{ route('tryout.result.answer') }}",
                dataType: 'json',
                data : {
                    exam_id,index
                },
                success: function(reply) {
                    console.log(reply);
                    
                    $(`.number-question-list[data-question-id="${reply?.question?.id}"]`).addClass('bg-indigo-400').prop('disabled',true)
                    
                    $('#number-question').text(index+1)
                    
                    $('#topic-question').text(reply?.question?.topic)

                    $(".question").text(reply?.question?.question).data('id',reply?.question?.id);

                    $('#your-answer').text(reply?.check_answer?.answer?.option ? reply?.check_answer?.answer?.option : "-");

                    if (reply?.check_answer?.is_correct === true) {
                        $('#answer-status').removeClass(['bg-red-100','text-red-800','bg-gray-200','text-gray-800']).addClass(['bg-green-100','text-green-800']).text('BENAR')
                        $('#your-answer').removeClass(['text-red-500']).addClass('text-green-500')
                    } else if (reply?.check_answer?.is_correct === false) {
                        $('#answer-status').removeClass(['bg-green-100','text-green-800','bg-gray-200','text-gray-800']).addClass(['bg-red-100','text-red-800']).text('SALAH')
                        $('#your-answer').removeClass(['text-green-500']).addClass('text-red-500')
                    } else {
                        $('#answer-status').removeClass(['bg-red-100','text-red-800','bg-green-100','text-green-800']).addClass(['bg-gray-200','text-gray-800']).text('KOSONG')
                        $('#your-answer').removeClass(['text-green-500','text-red-500'])
                    }
                    

                    // Tampilkan opsi jawaban
                    let answers = "";
                    $.each(reply?.question?.answers, function(i, answer) {
                        answers += `
                            <div class="flex justify-between items-center mb-2 space-x-2">
                                <label for="optionsRadios${answer?.option}" class="ml-3 flex items-center">
                                    <label for="optionsRadios${answer?.option}" class="fw-700 text-info">${answer?.option}. ${answer?.answer}</label>
                                </label>
                                <div class="flex items-center">
                                    <p class="px-2.5 py-0.5 w-20 text-center rounded-md text-sm font-meidum bg-gray-200 text-gray-800"> ${answer?.score} Point </p>
                                </div>
                            </div>
                        `

                        // print kunci jawaban
                        if(answer?.score == 5) $('#answer-key').text(answer?.option)
                    });
                    
                    $(".options").html(answers);

                    $(".explanation").html(reply?.question?.explanation)

                    // Atur tombol navigasi
                    $("#prev-button").toggle(index > 0);
                    $("#next-button").toggle(index < reply.total - 1);

                    currentIndex = index;
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }


        $(document).ready(function() {
            allQuestion()
            setTimeout(() => {
                selectedQuestion(0);
            }, 300);
        });

        // Event listener tombol navigasi
        $("#next-button").click(function() {
            selectedQuestion(currentIndex + 1);
        });

        $("#prev-button").click(function() {
            selectedQuestion(currentIndex - 1);
        });
    </script>
@endpush