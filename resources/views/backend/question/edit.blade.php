@extends('backend.layout.app')
@section('content')
    @include('backend.layout.breadcrumb',['content' => 'Edit Question'])

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="container mt-4">
                        <form action="{{ route('console.question.update', $question->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Category - Topic --}}
                            <div class="row mb-3">
                                <label for="topic_id" class="col-sm-2 col-form-label text-end">Category - Topic</label>
                                <div class="col-sm-12">
                                    <select class="form-control" id="topic_id" name="topic_id" onchange="updateScoreRules()">
                                        @foreach ($topics as $topic)
                                            <option value="{{ $topic->id }}"
                                                data-category="{{ $topic->category }}"
                                                {{ $question->topic_id == $topic->id ? 'selected' : '' }}>
                                                {{ $topic->category }} - {{ $topic->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Soal --}}
                            <div class="mb-3">
                                <label for="question" class="form-label">Soal</label>
                                <textarea name="question" id="question" class="form-control" required>{{ $question->question }}</textarea>
                            </div>
                            
                            {{-- Penjelasan --}}
                            <div class="mb-3">
                                <label for="explanation" class="form-label">Penjelasan</label>
                                <textarea name="explanation" id="explanation">{{ $question->explanation }}</textarea>
                            </div>

                            {{-- Jawaban --}}
                            <h4>Jawaban</h4>
                            @foreach($question->answers as $index => $answer)
                                @php $option = chr(65 + $index); @endphp
                                <div class="mb-2">
                                    <label class="form-label">Jawaban {{ $option }}</label>
                                    
                                    {{-- Input text TWK/TKP --}}
                                    <input type="text" 
                                           name="answers[{{ $index }}]" 
                                           class="form-control answer-input" 
                                           value="{{ $answer->answer }}"
                                           required>

                                    {{-- Textarea Summernote TIU --}}
                                    <textarea 
                                        id="answer_{{ $option }}" 
                                        name="answers[{{ $index }}]"
                                        class="form-control answer-textarea d-none"
                                        rows="2"
                                    >{{ $answer->answer }}</textarea>
                                </div>
                            @endforeach

                            {{-- Jawaban Benar (TWK/TIU) --}}
                            <div id="score-twk-tiu" class="mb-3" style="{{ $question->topic->category == 'TKP' ? 'display:none;' : '' }}">
                                <label for="correct_answer" class="form-label">Jawaban Benar</label>
                                <select name="correct_answer" id="correct_answer" class="form-control">
                                    @foreach(['A', 'B', 'C', 'D', 'E'] as $option)
                                        <option value="{{ $option }}"
                                            {{ $question->correct_answer == $option ? 'selected' : '' }}>
                                            {{ $option }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Skor TKP --}}
                            <div id="score-tkp" class="mb-3" style="{{ $question->topic->category == 'TKP' ? '' : 'display:none;' }}">
                                <label class="form-label">Skor</label>
                                @foreach($question->answers as $index => $answer)
                                    <input type="number" name="score_tkp[]" min="1" max="5" class="form-control mb-2"
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
$(function () {
    // Soal dan Penjelasan
    initSummernote('#question', 'question');
    initSummernote('#explanation', 'explanation');

    // Jawaban A–E
    ['A','B','C','D','E'].forEach(opt => {
        initSummernote(`#answer_${opt}`, `answer_${opt}`);
    });

    updateScoreRules(); // tampilkan sesuai kategori saat pertama kali load
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
    data.append("file", file);
    data.append("type", type);

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
        // tampilkan summernote jawaban
        $('.answer-input').addClass('d-none').attr('disabled', true).removeAttr('required');
        $('.answer-textarea').each(function(){
            $(this).removeClass('d-none').removeAttr('disabled').attr('required', true);
            $(this).next('.note-editor').show();
        });
    } else {
        // tampilkan input text jawaban
        $('.answer-textarea').each(function(){
            $(this).addClass('d-none').attr('disabled', true).removeAttr('required');
            $(this).next('.note-editor').hide();
        });
        $('.answer-input').removeClass('d-none').removeAttr('disabled').attr('required', true);
    }

    if (cat === 'TKP') {
        $('#score-twk-tiu').hide();
        $('#score-tkp').show();
        $('#correct_answer').val('');
    } else {
        $('#score-tkp').hide();
        $('#score-twk-tiu').show();
        $('input[name="score_tkp[]"]').val('');
    }
}
</script>
@endpush
