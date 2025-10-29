@extends('backend.layout.app')

@section('content')
    @include('backend.layout.breadcrumb',['content' => 'Create Question'])

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="container mt-4">
                        <form action="{{ route('console.tryout.question.store',$tryout?->id) }}" method="POST">
                            @csrf

                            {{-- Tryout --}}
                            <div class="row mb-3">
                                <label class="col-sm-12 col-form-label text-end">Tryout</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" disabled value="{{ $tryout?->title }}">
                                </div>
                            </div>

                            {{-- Topic --}}
                            <div class="row mb-3">
                                <label for="topic_id" class="col-sm-12 col-form-label text-end">Category - Topic</label>
                                <div class="col-sm-12">
                                    <select class="form-control" id="topic_id" name="topic_id" onchange="updateScoreRules()">
                                        @foreach ($topics as $topic)
                                            <option value="{{ $topic->id }}"
                                                data-category="{{ $topic->category }}"
                                                {{ old('topic_id') == $topic->id ? 'selected' : '' }}>
                                                {{ $topic->category }} - {{ $topic->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Nomor Soal --}}
                            <div class="row mb-3">
                                <label class="col-sm-12 col-form-label text-end">Nomor</label>
                                <div class="col-sm-12">
                                    <input type="number" class="form-control" name="order"
                                           value="{{ old('order', $number) }}">
                                </div>
                            </div>

                            {{-- Soal --}}
                            <div class="mb-3">
                                <label for="question" class="form-label">Soal</label>
                                <textarea name="question" id="question" class="form-control" required>{{ old('question') }}</textarea>
                            </div>

                            {{-- Penjelasan --}}
                            <div class="mb-3">
                                <label for="explanation" class="form-label">Penjelasan</label>
                                <textarea name="explanation" id="explanation">{{ old('explanation') }}</textarea>
                            </div>

                            {{-- Jawaban --}}
                            <h4>Jawaban</h4>
                            @foreach(['A', 'B', 'C', 'D', 'E'] as $i => $opt)
                                <div class="mb-2">
                                    <label class="form-label">Jawaban {{ $opt }}</label>

                                    {{-- input text TWK & TKP --}}
                                    <input type="text" name="answers[{{ $i }}]" class="form-control answer-input" value="{{ old('answers.'.$i) }}" required >

                                    {{-- textarea Summernote TIU --}}
                                    <textarea id="answer_{{ $opt }}" name="answers[{{ $i }}]" class="form-control answer-textarea d-none" rows="2">{{ old('answers.'.$i) }}</textarea>
                                </div>
                            @endforeach


                            {{-- Jawaban Benar (TWK/TIU) --}}
                            <div id="score-twk-tiu" class="mb-3">
                                <label for="correct_answer" class="form-label">Jawaban Benar</label>
                                <select name="correct_answer" id="correct_answer" class="form-control">
                                    @foreach(['A','B','C','D','E'] as $opt)
                                        <option value="{{ $opt }}" {{ old('correct_answer') == $opt ? 'selected' : '' }}>
                                            {{ $opt }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Skor (TKP) --}}
                            <div id="score-tkp" class="mb-3" style="display: none;">
                                <label class="form-label">Skor</label>
                                @foreach(['A', 'B', 'C', 'D', 'E'] as $index => $option)
                                    <input type="number" name="score_tkp[]"
                                           min="1" max="5"
                                           class="form-control mb-1"
                                           placeholder="Skor {{ $option }}"
                                           value="{{ old('score_tkp.'.$index) }}">
                                @endforeach
                            </div>

                            {{-- Submit --}}
                            <div class="row mt-4">
                                <div class="col-sm-6 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js-bottom')
    <script>
        $(function () {
            // Inisialisasi Summernote utk soal & penjelasan
            initSummernote('#question', 'question');
            initSummernote('#explanation', 'explanation');

            // Inisialisasi Summernote utk jawaban A–E
            ['A','B','C','D','E'].forEach(opt => {
                initSummernote(`#answer_${opt}`, `answer_${opt}`);
            });

            // Set tampilan awal sesuai kategori
            updateScoreRules();
        });

        function initSummernote(selector, type){
            $(selector).summernote({
                height: 100,
                toolbar: [['insert', ['picture']]],
                callbacks: {
                    onImageUpload: function(files){
                        uploadImage(files[0], selector, type);
                    }
                }
            });
        }

        function uploadImage(file, selector, type){
            const data = new FormData();
            data.append('file', file);
            data.append('type', type);

            $.ajax({
                url: "{{ route('console.question.image') }}",
                method: "POST",
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                data,
                processData: false,
                contentType: false,
                success: function(res){
                    const img = $('<img>').attr('src', res.imageUrl);
                    $(selector).summernote('insertNode', img[0]);
                },
                error: function(err){
                    alert("Upload gambar gagal. Pastikan file ≤ 2MB.");
                    console.error(err);
                }
            });
        }

        function updateScoreRules(){
            const cat = $("#topic_id option:selected").data("category");

            if (cat === 'TIU') {
                // tampilkan editor Summernote jawaban
                $('.answer-input')
                    .addClass('d-none')
                    .attr('disabled', true)
                    .removeAttr('required');

                $('.answer-textarea').each(function(){
                    $(this).removeClass('d-none')
                        .removeAttr('disabled')
                        .attr('required', true);
                    $(this).next('.note-editor').show();
                });
            } else {
                // tampilkan input text biasa
                $('.answer-textarea').each(function(){
                    $(this).addClass('d-none')
                        .attr('disabled', true)
                        .removeAttr('required');
                    $(this).next('.note-editor').hide();
                });

                $('.answer-input')
                    .removeClass('d-none')
                    .removeAttr('disabled')
                    .attr('required', true);
            }

            if (cat === 'TKP') {
                $('#score-twk-tiu').hide();
                $('#score-tkp').show();
            } else {
                $('#score-tkp').hide();
                $('#score-twk-tiu').show();
            }
        }
    </script>
@endpush

