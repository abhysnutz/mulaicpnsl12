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
                            @foreach(['A', 'B', 'C', 'D', 'E'] as $index => $option)
                                <div class="mb-2">
                                    <label class="form-label">Jawaban {{ $option }}</label>
                                    <input type="text" name="answers[]"
                                           class="form-control"
                                           value="{{ old('answers.'.$index) }}"
                                           required>
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
    $(document).ready(function () {
        $('#explanation, #question').summernote({
            height: 100,
            toolbar: [
                ['insert', ['picture']],
            ],
            callbacks: {
                onImageUpload: function (files) {
                    let editor_id = $(this).attr('id');
                    let type = (editor_id === 'question') ? 'question' : 'explanation';
                    uploadImage(files[0], editor_id, type);
                }
            }
        });

        // Trigger category rules saat load ulang
        updateScoreRules();
    });

    function uploadImage(file, editor_id, type) {
        var data = new FormData();
        data.append("file", file);
        data.append("type", type);

        $.ajax({
            url: "{{ route('console.question.image') }}",
            method: "POST",
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                var imgNode = $('<img>').attr('src', response.imageUrl);
                $(`#${editor_id}`).summernote('insertNode', imgNode[0]);
            },
            error: function (error) {
                console.log("Upload gagal:", error);
            }
        });
    }

    function updateScoreRules() {
        let selectedOption = $("#topic_id option:selected");
        let category = selectedOption.data("category");

        if (category === 'TKP') {
            $('#score-twk-tiu').hide();
            $('#score-tkp').show();
        } else {
            $('#score-tkp').hide();
            $('#score-twk-tiu').show();
        }
    }
</script>
@endpush
