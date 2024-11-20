<div class="container mt-4">
    <h1 class="text-center text-primary">Ôn tập từ vựng</h1>

    <div class="study-session card shadow-sm p-4">
        <!-- Hiển thị từ vựng -->
        <h2 class="text-center text-success">{{ $studySession->vocabulary->word }}</h2>
        <p class="text-center">
            <strong>Cấp độ hiện tại:</strong> {{ $studySession->level }}
        </p>

        <!-- Form phương pháp học -->
        <form action="{{ route('study-sessions.update', $studySession->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="currentMethod" value="{{ $currentMethod }}">

            @if($currentMethod === 'Flashcard')
                <div class="text-center">
                    <h3>{{ $studySession->vocabulary->word }}</h3>
                    <p><strong>Nghĩa:</strong> {{ $studySession->vocabulary->meaning }}</p>
                    <p><strong>Ví dụ:</strong> {{ $studySession->vocabulary->example_sentence }}</p>
                </div>
            @elseif($currentMethod === 'Nghe và viết lại')
                <div class="text-center">
                    <audio controls>
                        <source src="{{ asset('audio/' . $studySession->vocabulary->audio_url) }}" type="audio/mpeg">
                        Trình duyệt của bạn không hỗ trợ audio.
                    </audio>
                    <div class="form-group mt-3">
                        <label for="answer">Viết lại từ:</label>
                        <input type="text" name="answer" id="answer" class="form-control" required>
                    </div>
                </div>
            @elseif($currentMethod === 'Điền từ')
                <div class="form-group">
                    <label for="answer">Điền từ vào chỗ trống:</label>
                    <input type="text" name="answer" id="answer" class="form-control" required>
                </div>
            @endif

            <!-- Nút gửi -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary w-100">Nộp câu trả lời</button>
            </div>
        </form>
    </div>
</div>
