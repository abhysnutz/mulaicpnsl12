@extends('frontend.layout')
@section('content')
<div class="pt-4 pb-20 sm:pt-6 sm:pb-6" style="background-color:#f9fafb; min-height:100vh;">
    <div class="mx-auto px-4 sm:px-6 md:px-5">
        <div class="bg-white px-5 pt-5 pb-8 rounded-2xl shadow-sm border border-gray-100">
            @include('frontend.breadcrumb', ['content' => 'Pembahasan'])

            <div id="tryout" class="w-full flex flex-col mt-4">
                <div class="flex flex-col sm:flex-row sm:items-center mb-4">
                    <h5 class="text-lg font-semibold text-gray-800 sm:w-32 flex-shrink-0">Tryout</h5>
                    <p class="text-base text-gray-600 sm:ml-2">{{ $exam?->tryout?->title }}</p>
                </div>

                <!-- Tabs -->
                <div class="border-b border-gray-200">
                    <nav aria-label="Tabs" class="-mb-px flex space-x-8">
                        <a href="{{ route('tryout.result.statistic',$exam->id) }}" class="group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="-ml-0.5 mr-2 h-5 w-5 text-gray-400 group-hover:text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 13v-1m4 1v-3m4 3V8M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                            <span>Statistik</span>
                        </a>
                        <a href="#" class="group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm border-amber-500 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="-ml-0.5 mr-2 h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <span>Pembahasan</span>
                        </a>
                    </nav>
                </div>

                <div class="flex items-start flex-col lg:flex-row mt-6">
                    <!-- Kolom soal -->
                    <div class="w-full lg:w-4/6 2xl:w-9/12 lg:mr-5 mb-5">
                        <div class="px-5 py-6 sm:p-7 bg-white overflow-hidden shadow-md border border-gray-100 rounded-2xl">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-800"> Soal No.
                                    <span id="number-question"></span>
                                    <span id="topic-question" class="inline-flex items-center px-2.5 py-0.5 ml-2 rounded-md text-sm font-bold bg-amber-500 text-white shadow-sm"></span>
                                </h3>
                                <span id="answer-status" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500"></span>
                            </div>
                            <hr class="my-4 border-gray-100">

                            <div class="question text-gray-700 leading-relaxed"></div>
                            <div class="options py-5"></div>

                            <hr class="my-4 border-gray-100">

                            <!-- Detail jawaban -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div class="p-4 rounded-xl border border-gray-100" style="background-color:#f0fdf4;">
                                    <p class="text-xs font-semibold uppercase tracking-wide" style="color:#16a34a;">Kunci Jawaban</p>
                                    <p id="answer-key" class="mt-1 text-xl font-bold text-gray-900">-</p>
                                </div>
                                <div class="p-4 rounded-xl border border-gray-100" style="background-color:#f9fafb;">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Jawaban Anda</p>
                                    <p id="your-answer" class="mt-1 text-xl font-bold text-gray-900">-</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 mt-4 p-3 rounded-xl" style="background-color:#fffbeb;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 flex-shrink-0" style="color:#d97706;" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Waktu mengerjakan:</span>
                                <span id="question-duration" class="text-sm font-bold text-gray-900">-</span>
                            </div>

                            <!-- Pembahasan -->
                            <div class="mt-5">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5" style="color:#d97706;" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="font-bold text-gray-900">Pembahasan</h3>
                                </div>
                                <div class="explanation text-gray-700 leading-relaxed p-4 rounded-xl border border-gray-100" style="background-color:#fafafa;"></div>
                            </div>

                            <hr class="my-5 border-gray-100">

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

                            <hr class="my-5 border-gray-100">

                            <div class="text-center">
                                <button id="report-button" type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-600 hover:text-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Laporkan Soal Ini
                                </button>
                            </div>

                            <!-- Modal Report -->
                            <div id="report-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 p-4">
                                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
                                    <h3 class="text-lg font-semibold mb-4 text-gray-900">Laporkan Soal</h3>
                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Masalah</label>
                                        <select id="report-type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                            <option value="Jawaban salah">Jawaban salah</option>
                                            <option value="Soal typo / salah ketik">Soal typo / salah ketik</option>
                                            <option value="Gambar bermasalah">Gambar bermasalah</option>
                                            <option value="Pembahasan tidak sesuai">Pembahasan tidak sesuai</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                                        <textarea id="report-note" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="Jelaskan masalahnya..."></textarea>
                                    </div>
                                    <div class="flex justify-end space-x-2">
                                        <button id="report-cancel" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition">Batal</button>
                                        <button id="report-submit" type="button" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition">Kirim Laporan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom nomor soal -->
                    <div class="w-full lg:w-2/6 2xl:w-3/12 flex flex-col">
                        <div class="bg-white overflow-hidden shadow-md border border-gray-100 rounded-2xl mb-5">
                            <div class="px-4 py-4 font-semibold text-center text-gray-700 border-b border-gray-100">Nomor Soal</div>
                            <div class="px-4 py-4">
                                <div class="flex items-center justify-center gap-4 text-xs text-gray-500 mb-3">
                                    <span class="flex items-center"><span class="rounded mr-1.5" style="width:14px; height:14px; background-color:#9ca3af;"></span>Kosong</span>
                                    <span class="flex items-center"><span class="rounded mr-1.5" style="width:14px; height:14px; background-color:#34d399;"></span>Benar</span>
                                    <span class="flex items-center"><span class="rounded mr-1.5" style="width:14px; height:14px; background-color:#f87171;"></span>Salah</span>
                                </div>
                                <div id="question-number-list" class="flex flex-wrap justify-center"></div>
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
        var exam_id = {{ $exam->id }};
        var durations = {};
        var currentIndex = 0;

        // Ambil id soal dari item reply.data, baik berupa angka maupun object {id:...}
        function resolveQid(item) {
            if (item === null || item === undefined) return item;
            if (typeof item === 'object') return item.id ?? item.question_id ?? item;
            return item;
        }

        function allQuestion(){
            $.ajax({
                url: "{{ route('tryout.result.questions') }}",
                dataType: 'json',
                data : { exam_id },
                success : function(reply){
                    durations = reply.durations || {};

                    $.each(reply.data, function(index, item) {
                        let qid = resolveQid(item);
                        let button = $(`<button>`)
                            .attr("data-question-id", qid)
                            .attr('data-index', index)
                            .addClass("number-question-list bg-gray-400 text-white shadow-sm border border-gray-200 hover:border-amber-400 hover:shadow focus:outline-none focus:ring focus:ring-amber-300 py-1.5 rounded-lg m-1 text-center w-9 font-medium transition-all")
                            .text(index + 1)
                            .on("click", function() {
                                selectedQuestion(index);
                            });
                        $('#question-number-list').append(button);
                    });

                    $.each(reply.is_answers, function(index, is_answer) {
                        let sel = `.number-question-list[data-question-id="${is_answer?.question_id}"]`;
                        if (is_answer?.is_correct === true) {
                            $(sel).removeClass('bg-gray-400').addClass('bg-green-400 text-white');
                        } else if (is_answer?.is_correct === false) {
                            $(sel).removeClass('bg-gray-400').addClass('bg-red-400 text-white');
                        } else {
                            $(sel).addClass('bg-gray-400 text-white');
                        }
                    });
                }
            });
        }

        function formatDuration(sec) {
            if (!sec || sec <= 0) return "-";
            const m = Math.floor(sec / 60);
            const s = sec % 60;
            if (m === 0) return `${s} detik`;
            if (s === 0) return `${m} menit`;
            return `${m} menit ${s} detik`;
        }

        function selectedQuestion(index) {
            // reset state aktif tanpa menghapus warna benar/salah
            $(`.number-question-list`).removeClass('ring-2 ring-amber-400 ring-offset-1').prop('disabled', false);

            $.ajax({
                url: "{{ route('tryout.result.answer') }}",
                dataType: 'json',
                data : { exam_id, index },
                success: function(reply) {
                    $(`.number-question-list[data-question-id="${reply?.question?.id}"]`)
                        .addClass('ring-2 ring-amber-400 ring-offset-1').prop('disabled', true);

                    $('#number-question').text(index + 1);
                    $('#topic-question').text(reply?.question?.topic);
                    $(".question").html(reply?.question?.question).data('id', reply?.question?.id);

                    $('#your-answer').text(reply?.check_answer?.answer?.option ? reply?.check_answer?.answer?.option : "-");

                    if (reply?.check_answer?.is_correct === true) {
                        $('#answer-status').removeClass('bg-red-100 text-red-800 bg-gray-100 text-gray-500').addClass('bg-green-100 text-green-800').text('BENAR');
                        $('#your-answer').removeClass('text-red-500').addClass('text-green-600');
                    } else if (reply?.check_answer?.is_correct === false) {
                        $('#answer-status').removeClass('bg-green-100 text-green-800 bg-gray-100 text-gray-500').addClass('bg-red-100 text-red-800').text('SALAH');
                        $('#your-answer').removeClass('text-green-600').addClass('text-red-500');
                    } else {
                        $('#answer-status').removeClass('bg-red-100 text-red-800 bg-green-100 text-green-800').addClass('bg-gray-100 text-gray-500').text('KOSONG');
                        $('#your-answer').removeClass('text-green-600 text-red-500');
                    }

                    // Opsi jawaban + kunci
                    let answers = "";
                    let key = "-";
                    $.each(reply?.question?.answers, function(i, answer) {
                        if (answer?.score == 5) key = answer?.option;
                        answers += `
                            <div class="flex justify-between items-center mb-2 gap-2 p-2 rounded-lg border border-gray-100">
                                <span class="text-gray-700">${answer?.option}. ${answer?.answer}</span>
                                <span class="px-2.5 py-0.5 w-20 text-center rounded-md text-sm font-medium bg-gray-100 text-gray-700 flex-shrink-0">${answer?.score} Poin</span>
                            </div>`;
                    });
                    $(".options").html(answers);
                    $('#answer-key').text(key);

                    $(".explanation").html((reply?.question?.explanation ?? "").replace(/\n/g, "<br>"));

                    const qid = reply?.question?.id;
                    const duration = durations[qid] ?? 0;
                    $('#question-duration').text(formatDuration(duration));

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
            allQuestion();
            setTimeout(() => {
                selectedQuestion(0);
            }, 300);
        });

        $("#next-button").click(function() { selectedQuestion(currentIndex + 1); });
        $("#prev-button").click(function() { selectedQuestion(currentIndex - 1); });

        $('#report-button').on('click', function() {
            $('#report-modal').removeClass('hidden').addClass('flex');
        });
        $('#report-cancel').on('click', function() {
            $('#report-modal').addClass('hidden').removeClass('flex');
        });

        $('#report-submit').on('click', function() {
            const questionId = $('.question').data('id');
            if (!questionId) {
                alert('Soal belum termuat, coba lagi.');
                return;
            }
            const $btn = $(this);
            $btn.prop('disabled', true).text('Mengirim...');
            $.ajax({
                url: "{{ route('tryout.question.report') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    question_id: questionId,
                    exam_id: exam_id,
                    type: $('#report-type').val(),
                    note: $('#report-note').val()
                },
                success: function(reply) {
                    alert(reply.message || 'Laporan terkirim!');
                    $('#report-modal').addClass('hidden').removeClass('flex');
                    $('#report-note').val('');
                },
                error: function(xhr) {
                    alert('Gagal mengirim laporan. Coba lagi.');
                    console.log(xhr.responseText);
                },
                complete: function() {
                    $btn.prop('disabled', false).text('Kirim Laporan');
                }
            });
        });
    </script>
@endpush