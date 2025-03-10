@extends('backend.layout.app')
@section('content')
    @include('backend.layout.breadcrumb',['content' => 'Edit Question'])

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="container mt-4">
                        <form action="{{ route('console.tryout.question.update', [$tryout?->id, $question?->id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label class="col-sm-12 col-form-label text-end">Tryout</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" disabled value="{{ $tryout?->title }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="topic_id" class="col-sm-2 col-form-label text-end">Category - Topic</label>
                                <div class="col-sm-12">
                                    <select class="form-control" id="topic_id" name="topic_id" onchange="updateScoreRules()">
                                        @foreach ($topics as $topic)
                                            <option value="{{ $topic?->id }}" data-category = "{{ $topic?->category }}" 
                                                {{ $question->topic_id == $topic->id ? 'selected' : '' }}>
                                                {{ $topic?->category }} - {{ $topic?->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-12 col-form-label text-end">Nomor</label>
                                <div class="col-sm-12">
                                    <input type="number" class="form-control" name="order" value="{{ $question->order }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="question" class="form-label">Soal</label>
                                <textarea name="question" id="question" class="form-control" required>{{ $question->question }}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="explanation" class="form-label">Penjelasan</label>
                                <textarea name="explanation" id="explanation">{{ $question->explanation }}</textarea>
                            </div>

                            <h4>Jawaban</h4>
                            @foreach($question->answers as $index => $answer)
                                <div class="mb-2">
                                    <label class="form-label">Jawaban {{ chr(65 + $index) }}</label>
                                    <input type="text" name="answers[]" class="form-control" required value="{{ $answer->answer }}">
                                </div>
                            @endforeach

                            <div id="score-twk-tiu" class="mb-3" style="{{ $question->topic->category == 'TKP' ? 'display:none;' : '' }}">
                                <label for="correct_answer" class="form-label">Jawaban Benar</label>
                                <select name="correct_answer" id="correct_answer" class="form-control">
                                    @foreach(['A', 'B', 'C', 'D', 'E'] as $option)
                                        <option value="{{ $option }}" {{ $question->correct_answer == $option ? 'selected' : '' }}>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="score-tkp" class="mb-3" style="{{ $question->topic->category == 'TKP' ? '' : 'display:none;' }}">
                                <label class="form-label">Skor</label>
                                @foreach($question->answers as $index => $answer)
                                    <input type="number" name="score_tkp[]" min="1" max="5" class="form-control" 
                                        placeholder="Skor {{ chr(65 + $index) }}" value="{{ $answer->score }}">
                                @endforeach
                            </div>

                            <div class="row">
                                <div class="col-sm-2"></div> 
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
        $(document).ready(function() {
            $('#explanation, #question').summernote({
                height: 100,
                toolbar: [
                    ['insert', ['picture']],
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        let editor_id = $(this).attr('id');
                        uploadImage(files[0], editor_id);
                    }
                }
            });
        });

        function uploadImage(file, editor_id) {
            var data = new FormData();
            data.append("file", file);
            
            $.ajax({
                url: "/upload-image",
                method: "POST",
                data: data,
                processData: false,
                contentType: false,
                success: function(response) {
                    var imgNode = $('<img>').attr('src', response.imageUrl);
                    $(`#${editor_id}`).summernote('insertNode', imgNode[0]);
                },
                error: function(error) {
                    console.log("Upload gagal:", error);
                }
            });
        }
        
        function updateScoreRules() {
            let selectedOption = $("#topic_id option:selected");
            let category = selectedOption.data("category");
            if(category == 'TKP'){
                $('#score-twk-tiu').hide();
                $('#score-tkp').show();
            } else {
                $('#score-tkp').hide();
                $('#score-twk-tiu').show();
            }
        }
    </script>
@endpush
