@extends('frontend.layout')
@section('content')
<div class="pt-4 pb-20 sm:pt-6 sm:pb-6 bg-gray-50 min-h-screen">
    <div class="mx-auto px-4 sm:px-6 md:px-5">
        <div class="bg-white px-5 pt-5 pb-8 rounded-2xl shadow-sm border border-gray-100">
            <div>
                <div>
                    <div class="flex items-start flex-col lg:flex-row">
                        <div class="w-full lg:w-4/6 2xl:w-4/5 lg:mr-5 mb-5">
                            <!-- Timer (mobile) -->
                            <div class="overflow-hidden rounded-xl mb-5 lg:hidden bg-amber-50 border border-amber-100 shadow-sm">
                                <div class="px-4 py-4 text-center">
                                    <span class="text-xs font-medium text-amber-600 uppercase tracking-wide">Waktu Tersisa</span>
                                    <h4 class="time-remaining font-bold text-4xl text-amber-600 mt-1"></h4>
                                </div>
                            </div>

                            <div id="questionContainer" class="relative px-5 py-6 sm:p-7 bg-white overflow-hidden shadow-md hover:shadow-lg transition-shadow border border-gray-100 rounded-2xl">
                                <!-- Overlay loading -->
                                <div id="question-loading"><div class="spinner"></div></div>

                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg font-semibold text-gray-800"> Soal No.
                                        <span id="number-question"></span>
                                        <span id="topic-question" class="inline-flex items-center px-2.5 py-0.5 ml-2 rounded-md text-sm font-bold bg-amber-500 text-white shadow-sm"></span>
                                    </h3>
                                    <button id="btn-working-help" class="flex justify-center bg-blue-100 text-blue-700 px-3 py-2 items-center rounded-lg shadow-sm hover:bg-blue-200 hover:shadow transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg> Bantuan </button>
                                </div>
                                <hr class="my-4 border-gray-100">
                                <div>
                                    <div class="question text-gray-700 leading-relaxed">

                                    </div>
                                    <div class="options py-5">

                                    </div>
                                </div>
                                <hr class="my-4 border-gray-100">

                                <div class="flex justify-center">
                                    <button id="prev-button" type="button" class="flex items-center mx-2 px-4 py-2.5 text-sm leading-4 font-medium rounded-lg shadow-sm hover:shadow text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                        </svg> Sebelumnya </button>
                                    <button id="next-button" type="button" class="flex items-center mx-2 px-4 py-2.5 text-sm leading-4 font-medium rounded-lg shadow-md hover:shadow-lg text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all"> Selanjutnya
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 ml-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="w-full lg:w-2/6 2xl:w-1/5 flex flex-col">
                            <!-- Timer (desktop) -->
                            <div class="overflow-hidden rounded-xl mb-5 hidden lg:block bg-amber-50 border border-amber-100 shadow-sm">
                                <div class="px-4 py-3 text-center">
                                    <span class="text-xs font-medium text-amber-600 uppercase tracking-wide">Waktu Tersisa</span>
                                    <h4 class="time-remaining font-bold text-4xl text-amber-600 mt-1"></h4>
                                </div>
                            </div>

                            <div class="bg-white overflow-hidden shadow-md border border-gray-100 rounded-2xl mb-5">
                                <div class="px-4 py-4 font-semibold text-center text-gray-700 border-b border-gray-100">Nomor Soal</div>
                                <div class="flex flex-wrap px-3 py-3 justify-center">
                                    <div id="question-number-list" class="flex flex-wrap justify-center">
                                    </div>
                                </div>
                                <!-- Legend -->
                                <div class="legend-wrap">
                                    <span class="legend-item"><span class="legend-dot legend-belum"></span>Belum</span>
                                    <span class="legend-item"><span class="legend-dot legend-terjawab"></span>Terjawab</span>
                                    <span class="legend-item"><span class="legend-dot legend-aktif"></span>Aktif</span>
                                </div>
                            </div>

                            <div class="bg-white overflow-hidden shadow-md border border-gray-100 rounded-2xl mb-5 hidden lg:block">
                                <div class="px-4 py-5 sm:p-6 text-center">
                                    <div class="font-semibold mb-3 text-gray-700">Sudah selesai ?</div>
                                    <div class="flex justify-center">
                                        <button type="button" class="btn-cancel-open flex items-center mx-2 px-4 py-2.5 text-sm leading-4 font-medium rounded-lg shadow-sm hover:shadow text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400 transition-all">BATAL</button>
                                        <button type="button" class="btn-finish-open flex items-center mx-2 px-4 py-2.5 text-sm leading-4 font-medium rounded-lg shadow-md hover:shadow-lg text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all">SELESAI</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="questionBox" class="w-full bg-white overflow-hidden shadow-md border border-gray-100 rounded-2xl mb-5 lg:hidden">
                            <div class="px-4 py-5 sm:p-6 text-center">
                                <div class="font-semibold mb-3 text-gray-700">Sudah selesai?</div>
                                <div class="flex justify-center">
                                    <button type="button" class="btn-cancel-open flex items-center mx-2 px-4 py-2.5 text-sm leading-4 font-medium rounded-lg shadow-sm hover:shadow text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400 transition-all">BATAL</button>
                                    <button type="button" class="btn-finish-open flex items-center mx-2 px-4 py-2.5 text-sm leading-4 font-medium rounded-lg shadow-md hover:shadow-lg text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all">SELESAI</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal: Panduan -->
                    <div class="fixed z-10 inset-0 overflow-y-auto alert-overflow" style="display: none;">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div aria-hidden="true" class="fixed inset-0 transition-opacity alert-background" style="display: none;">
                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                            </div>
                            <span aria-hidden="true" class="hidden sm:inline-block sm:align-middle sm:h-screen">​</span>
                            <div role="dialog" aria-modal="true" aria-labelledby="modal-headline" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full alert-content" style="display: none;">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-7 mr-1 text-blue-500">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3 id="modal-headline" class="text-lg leading-6 font-semibold text-gray-900">Panduan</h3>
                                            <div class="mt-2">
                                                <ol class="text-gray-600 text-sm list-decimal pl-2 space-y-1">
                                                    <li><p>Pilih jawaban yang menurut Anda benar.</p></li>
                                                    <li><p> Klik tombol <kbd class="bg-gray-700 text-white px-1 rounded">sebelumnya</kbd> dan <kbd class="bg-gray-700 text-white px-1 rounded">selanjutnya</kbd> untuk berpindah soal. </p></li>
                                                    <li><p> Anda dapat berpindah ke nomor soal yang dipilih dengan klik nomor pada peta soal. </p></li>
                                                    <li><p> Klik <kbd class="bg-gray-700 text-white px-1 rounded">Batal</kbd> apabila ingin membatalkan latihan. </p></li>
                                                    <li><p> Klik <kbd class="bg-gray-700 text-white px-1 rounded">Selesai</kbd> apabila ingin menyelesaikan latihan. </p></li>
                                                    <li><p>Pastikan internet stabil saat submit jawaban.</p></li>
                                                    <li><p> Apabila mengalami masalah seperti: soal/pilihan jawaban tidak berubah, pilihan jawaban tidak dapat dipilih, mohon untuk menggunakan browser Google Chrome versi terbaru. </p></li>
                                                    <li><p> Kami merekomendasikan untuk akses menggunakan Google Chrome supaya tidak mengalami masalah seperti poin nomor 7. </p></li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button id="btn-working-close" type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal: Batal -->
                    <div class="fixed z-10 inset-0 overflow-y-auto alert-cancel-overflow" style="display: none;">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div aria-hidden="true" class="fixed inset-0 transition-opacity alert-cancel-background" style="display: none;">
                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                            </div>
                            <span aria-hidden="true" class="hidden sm:inline-block sm:align-middle sm:h-screen">​</span>
                            <div role="dialog" aria-modal="true" aria-labelledby="modal-headline" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full alert-cancel-content" style="display: none;">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-7 mr-1 text-red-500">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                            </svg>
                                        </div>
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3 id="modal-headline" class="text-lg leading-6 font-semibold text-red-600">Batalkan Latihan?</h3>
                                            <div class="mt-2">
                                                <p class="mb-3"> Apakah anda yakin ingin membatalkan Latihan? Jawaban Anda tidak akan disimpan. </p>
                                                <div class="flex items-center space-x-2">
                                                    <form action="{{ route('tryout.cancel',$exam->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="mt-3 w-full inline-flex justify-center rounded-lg border border-red-300 shadow-sm hover:shadow px-4 py-2 bg-red-500 text-base font-medium text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:w-auto sm:text-sm transition">Ya, Batal</button>
                                                    </form>
                                                    <button type="button" class="btn-cancel-close mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal: Selesai -->
                    <div class="fixed z-10 inset-0 overflow-y-auto alert-finish-overflow" style="display: none;">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div aria-hidden="true" class="fixed inset-0 transition-opacity alert-finish-background" style="display: none;">
                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                            </div>
                            <span aria-hidden="true" class="hidden sm:inline-block sm:align-middle sm:h-screen">​</span>
                            <div role="dialog" aria-modal="true" aria-labelledby="modal-headline" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full alert-finish-content" style="display: none;">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-amber-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-7 mr-1 text-amber-500">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                            </svg>
                                        </div>
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3 id="modal-headline" class="text-lg leading-6 font-semibold text-amber-600">Submit Jawaban Sekarang?</h3>
                                            <div class="mt-2">
                                                <p class="mb-3">Jawaban yang telah disubmit tidak dapat diubah.</p>
                                                <div class="flex items-center space-x-2">
                                                    <form id="form-finish" action="{{ route('tryout.finish',$exam->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="mt-3 w-full inline-flex justify-center rounded-lg border border-amber-300 shadow-sm hover:shadow px-4 py-2 bg-amber-500 text-base font-medium text-white hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:mt-0 sm:w-auto sm:text-sm transition">
                                                            <span>Submit</span>
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn-finish-close mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">Tutup</button>
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
    var exam_id = {{ $exam->id }}; // ID ujian dari backend
    let timerInterval = null;
    let currentQuestionId = null;
    let currentIndex = 0;
    let userExamId = "{{ $exam->id }}";
    let isNavigating = false;

    function disableAnswers() {
        $("input[name='answer']").prop("disabled", true);
        $("#next-button, #prev-button").prop("disabled", true);
        $(".number-question-list").prop("disabled", true);
    }

    function allQuestion() {
        $.ajax({
            url: "{{ route('tryout.questions') }}",
            dataType: 'json',
            data: { exam_id },
            success: function(reply) {
                $('#question-number-list').empty();

                $.each(reply.data, function(index, question) {
                    let button = $("<button>")
                        .attr("data-question-id", question.id)
                        .attr("data-index", index)
                        .addClass("number-question-list bg-gray-200 text-gray-700 shadow-sm border border-gray-200 hover:border-amber-400 hover:shadow focus:outline-none focus:ring focus:ring-amber-300 py-1.5 rounded-lg m-1 text-center w-9 font-medium transition-all")
                        .text(index + 1)
                        .on("click", function() {
                            goTo(index);
                        });
                    $('#question-number-list').append(button);
                });

                $(`.number-question-list[data-index='0']`).prop('disabled', true);

                $.each(reply.is_answers, function(index, is_answer) {
                    $(`.number-question-list[data-question-id='${is_answer}']`)
                        .attr('data-answered', '1')
                        .removeClass('bg-gray-200 text-gray-700')
                        .addClass(['bg-green-400', 'text-white']);
                });
            }
        });
    }

    function selectedQuestion(index, afterLoad) {
        // reset hanya state "aktif", jangan hapus warna terjawab
        $(`.number-question-list`).each(function() {
            $(this).removeClass('bg-amber-500 ring-2 ring-amber-300 ring-offset-1 bg-green-400 bg-gray-200 text-gray-700 text-white').prop('disabled', false);
            if ($(this).attr('data-answered') === '1') {
                $(this).addClass('bg-green-400 text-white');
            } else {
                $(this).addClass('bg-gray-200 text-gray-700');
            }
        });
        $.ajax({
            url: "{{ route('tryout.question') }}",
            dataType: 'json',
            data: { exam_id, index },
            success: function(reply) {

                $(`.number-question-list[data-question-id='${reply?.question?.id}']`)
                    .removeClass('bg-gray-200 text-gray-700 bg-green-400')
                    .addClass('bg-amber-500 text-white ring-2 ring-amber-300 ring-offset-1').prop('disabled', true);

                $('#number-question').text(index + 1);
                $('#topic-question').text(reply?.question?.topic);
                $(".question").html(reply?.question?.question).data('id', reply?.question?.id);

                let answers = "";
                $.each(reply?.question?.answers, function(i, answer) {
                    let checked = reply?.selected_answer == answer.id ? "checked" : "";
                    answers += `
                        <div class="flex items-center mb-2">
                            <label for="optionsRadios${answer?.option}" class="w-full flex items-center p-3 rounded-lg border border-gray-200 hover:border-amber-400 hover:bg-amber-50 cursor-pointer transition-all">
                                <input name="answer" type="radio" id="optionsRadios${answer?.option}"
                                    class="focus:ring-amber-500 h-4 w-4 text-amber-600 border-gray-300 mr-3"
                                    value="${answer?.id}" ${checked}>
                                <span class="text-gray-700">${answer?.option}. ${answer?.answer}</span>
                            </label>
                        </div>`;
                });
                $(".options").html(answers);

                $("#prev-button").toggle(index > 0);
                $("#next-button").toggle(index < reply.total - 1);

                currentIndex = index;
                const qid = reply?.question?.id;
                if (typeof afterLoad === "function") afterLoad(qid);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                isNavigating = false;
                $('#question-loading').removeClass('show');
                $("#next-button, #prev-button").prop("disabled", false);
            }
        });
    }

    function startQuestion(questionId) {
        currentQuestionId = questionId;
        fetch("{{ route('tryout.question.start') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                user_exam_id: userExamId,
                question_id: questionId
            })
        });
    }

    function endQuestion(questionId) {
        if (!questionId) return;
        fetch("{{ route('tryout.question.end') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                user_exam_id: userExamId,
                question_id: questionId
            })
        });
    }

    function getTime() {
        $.ajax({
            url: "{{ route('tryout.time') }}",
            dataType: 'json',
            data: { exam_id },
            success: function(reply) {
                const endTime = new Date(reply.end_time).getTime();

                function updateTimer() {
                    const now = new Date().getTime();
                    const remaining = Math.floor((endTime - now) / 1000);

                    if (remaining <= 0) {
                        clearInterval(timerInterval);
                        $(".time-remaining").text("00:00:00");
                        alert("Waktu ujian telah habis!");
                        disableAnswers();
                        $('#form-finish').submit();
                        return;
                    }

                    const hours = Math.floor(remaining / 3600);
                    const minutes = Math.floor((remaining % 3600) / 60);
                    const seconds = remaining % 60;

                    $(".time-remaining").text(
                        `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`
                    );
                }

                updateTimer();
                timerInterval = setInterval(updateTimer, 1000);
            }
        });
    }

    function saveAnswer() {
        let answer_id = $("input[name='answer']:checked").val();
        let question_id = $(".question").data("id");

        if (answer_id) {
            $.ajax({
                type: "POST",
                url: "{{ route('tryout.answer') }}",
                data: { exam_id, question_id, answer_id },
                async: true
            }).done(function() {
                $(`.number-question-list[data-question-id='${question_id}']`)
                    .attr('data-answered', '1')
                    .removeClass('bg-gray-200 text-gray-700')
                    .addClass('bg-green-400 text-white');
            }).fail(function(xhr) {
                console.log("Gagal menyimpan jawaban", xhr.responseText);
            });
        }
    }

    function goTo(index) {
        if (isNavigating || (typeof currentIndex === "number" && index === currentIndex)) return;
        isNavigating = true;
        $('#question-loading').addClass('show');

        if (currentQuestionId) endQuestion(currentQuestionId);

        selectedQuestion(index, function(qid) {
            currentQuestionId = qid;
            startQuestion(qid);
            isNavigating = false;
            $('#question-loading').removeClass('show');
        });
    }

    $(document).ready(function() {
        allQuestion();
        setTimeout(() => {
            getTime();
            selectedQuestion(0, function(qid) {
                startQuestion(qid); // start tracking soal pertama
            });
        }, 300);
    });

    $(document).on("change", "input[name='answer']", function() {
        saveAnswer();
    });

    $('#form-finish').on('submit', function() {
        if (currentQuestionId) endQuestion(currentQuestionId);
    });

    // Kirim end saat tab ditutup/refresh (pakai sendBeacon agar terkirim walau halaman ditutup)
    function endQuestionBeacon(questionId) {
        if (!questionId || !navigator.sendBeacon) return;
        const data = new FormData();
        data.append('user_exam_id', userExamId);
        data.append('question_id', questionId);
        data.append('_token', "{{ csrf_token() }}");
        navigator.sendBeacon("{{ route('tryout.question.end') }}", data);
    }

    window.addEventListener('beforeunload', function() {
        if (currentQuestionId) endQuestionBeacon(currentQuestionId);
    });

    window.addEventListener('focus', () => { getTime(); });

    $("#next-button").click(() => goTo(currentIndex + 1));
    $("#prev-button").click(() => goTo(currentIndex - 1));

    $(document).on('keydown', function(e) {
        // Navigasi panah kiri/kanan
        if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
            if ($(e.target).is("input[type='radio']")) {
                e.preventDefault();
            }
            if (e.key === 'ArrowRight') goTo(currentIndex + 1);
            if (e.key === 'ArrowLeft')  goTo(currentIndex - 1);
            return;
        }

        // Pilih opsi dengan huruf A-E
        let key = e.key.toUpperCase();
        if (['A', 'B', 'C', 'D', 'E'].includes(key)) {
            let $radio = $(`#optionsRadios${key}`);
            if ($radio.length) {
                $radio.prop('checked', true).trigger('change');
            }
        }
    });

    $('#btn-working-help').on('click', function() {
        $('.alert-overflow, .alert-background, .alert-content').fadeIn("fast");
    });

    $('#btn-working-close').on('click', function() {
        $('.alert-overflow, .alert-background, .alert-content').fadeOut("fast");
    });

    $('.btn-finish-open').on('click', function() {
        $('.alert-finish-overflow, .alert-finish-background, .alert-finish-content').fadeIn("fast");
    });

    $('.btn-finish-close').on('click', function() {
        $('.alert-finish-overflow, .alert-finish-background, .alert-finish-content').fadeOut("fast");
    });

    $('.btn-cancel-open').on('click', function() {
        $('.alert-cancel-overflow, .alert-cancel-background, .alert-cancel-content').fadeIn("fast");
    });

    $('.btn-cancel-close').on('click', function() {
        $('.alert-cancel-overflow, .alert-cancel-background, .alert-cancel-content').fadeOut("fast");
    });
</script>
@endpush