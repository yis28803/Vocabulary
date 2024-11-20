<div class="container mt-4">
    <h1 class="text-center text-primary">Ôn tập từ vựng</h1>

    <div class="study-session card shadow-sm p-4">
        <!-- Hiển thị từ vựng -->
        <h2 class="text-center text-success">{{ $studySession->vocabulary->word }}</h2>
        <p class="text-center"><strong>Cấp độ hiện tại:</strong> {{ $studySession->level }}</p>

        <!-- Hiển thị câu hỏi -->
        <div class="mb-3">
            <p><strong>Câu hỏi:</strong></p>
            <p class="text-secondary">{{ $studySession->question }}</p>
        </div>

        <!-- Điều kiện theo phương pháp học -->
        <form action="{{ route('study-sessions.update', $studySession->id) }}" method="POST" class="mt-3">
            @csrf
            @method('PUT')

            @if($studySession->studyMethod->name === 'Nghe và viết lại')
                <!-- Nghe và viết lại -->
                <div class="mb-3">
                    <p><strong>Nghe từ:</strong></p>
                    <audio controls class="w-100">
                        <source src="{{ $studySession->audio }}" type="audio/mpeg">
                        Trình duyệt của bạn không hỗ trợ thẻ audio.
                    </audio>
                </div>
                <div class="form-group">
                    <label for="answer">Viết lại từ:</label>
                    <input type="text" name="answer" id="answer" class="form-control" placeholder="Nhập từ bạn nghe được...">
                </div>

            @elseif($studySession->studyMethod->name === 'Điền từ')
                <!-- Điền từ -->
                <div class="mb-3">
                    <p><strong>Câu:</strong></p>
                    <p class="text-secondary">
                        {!! str_replace($studySession->vocabulary->word, '<strong>___</strong>', htmlspecialchars($studySession->vocabulary->example_sentence)) !!}
                    </p>
                </div>
                <div class="form-group">
                    <label for="answer">Điền từ:</label>
                    <input type="text" name="answer" id="answer" class="form-control" placeholder="Nhập từ vào chỗ trống...">
                </div>

            @elseif($studySession->studyMethod->name === 'Chọn nghĩa của từ được gạch chân')
                <!-- Chọn nghĩa của từ được gạch chân -->
                <div class="mb-3">
                    <p><strong>Câu:</strong></p>
                    <p class="text-secondary">
                        {!! str_replace($studySession->vocabulary->word, '<u>' . htmlspecialchars($studySession->vocabulary->word) . '</u>', htmlspecialchars($studySession->vocabulary->example_sentence)) !!}
                    </p>
                </div>
                <div class="form-group">
                    <label>Chọn nghĩa của từ:</label>
                    @if(!empty($studySession->options) && is_array($studySession->options))
                        @foreach($studySession->options as $key => $option)
                            <div class="form-check">
                                <input type="radio" name="answer" value="{{ $option }}" id="option_{{ $key }}" class="form-check-input">
                                <label for="option_{{ $key }}" class="form-check-label">{{ $option }}</label>
                            </div>
                        @endforeach
                    @else
                        <p class="text-danger">Không có tùy chọn khả dụng cho câu hỏi này.</p>
                    @endif
                </div>

            @else
                <!-- Các phương pháp khác -->
                <div class="form-group">
                    <label for="answer">Chọn câu trả lời đúng:</label>
                    <div class="form-check">
                        <input type="radio" id="correct" name="answer" value="1" class="form-check-input">
                        <label for="correct" class="form-check-label">Đúng</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="incorrect" name="answer" value="0" class="form-check-input">
                        <label for="incorrect" class="form-check-label">Sai</label>
                    </div>
                </div>
            @endif

            <!-- Nút gửi câu trả lời -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary w-100">Nộp câu trả lời</button>
            </div>
        </form>
    </div>
</div>
