<div class="container">
    <h1>Ôn tập từ vựng</h1>

    <div class="study-session">
        <h2>{{ $studentCard->vocabulary->word }}</h2>

        <p><strong>Cấp độ hiện tại:</strong> {{ $studentCard->level }}</p>

        <!-- Hiển thị câu hỏi -->
        <p><strong>Câu hỏi:</strong> {{ $studentCard->question }}</p>

        @if($studentCard->studyMethod->name === 'Nghe và viết lại')
            <!-- Nghe và viết lại -->
            <p><strong>Nghe từ:</strong></p>
            <audio controls>
                <source src="{{ $studentCard->audio }}" type="audio/mpeg">
                Trình duyệt của bạn không hỗ trợ thẻ audio.
            </audio>
            <form action="{{ route('study-card.update', $studentCard->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="answer">Viết lại từ:</label>
                    <input type="text" name="answer" id="answer" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Ôn tập lại</button>
            </form>

        @elseif($studentCard->studyMethod->name === 'Điền từ')
            <!-- Điền từ -->
            <p><strong>Câu:</strong> {{ str_replace($studentCard->vocabulary->word, '___', $studentCard->vocabulary->example_sentence) }}</p>
            <form action="{{ route('study-card.update', $studentCard->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="answer">Điền từ:</label>
                    <input type="text" name="answer" id="answer" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Ôn tập lại</button>
            </form>

        @elseif($studentCard->studyMethod->name === 'Chọn nghĩa của từ được gạch chân')
            <!-- Chọn nghĩa của từ được gạch chân -->
            <p><strong>Câu:</strong> {!! str_replace($studentCard->vocabulary->word, '<u>' . $studentCard->vocabulary->word . '</u>', $studentCard->vocabulary->example_sentence) !!}</p>
            <form action="{{ route('study-card.update', $studentCard->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Chọn nghĩa của từ:</label><br>
                    @foreach($studentCard->options as $key => $option)
                        <input type="radio" name="answer" value="{{ $option }}" id="option_{{ $key }}">
                        <label for="option_{{ $key }}">{{ $option }}</label><br>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Ôn tập lại</button>
            </form>

        @else
            <!-- Các phương pháp khác (Flashcard, Chọn nghĩa của từ) -->
            <form action="{{ route('study-card.update', $studentCard->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="answer">Chọn câu trả lời đúng:</label>
                    <input type="radio" id="correct" name="answer" value="1">
                    <label for="correct">Đúng</label><br>

                    <input type="radio" id="incorrect" name="answer" value="0">
                    <label for="incorrect">Sai</label><br>
                </div>

                <button type="submit" class="btn btn-primary">Ôn tập lại</button>
            </form>
        @endif

    </div>
</div>
