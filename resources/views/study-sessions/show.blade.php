<div class="container mt-4">
    <h1 class="text-center text-primary">Ôn tập từ vựng</h1>

    <div class="study-session card shadow-sm p-4">
        <!-- Hiển thị từ vựng -->
        <h2 class="text-center text-success">{{ $studySession->vocabulary->word }}</h2>
        <p class="text-center">
            <strong>Cấp độ hiện tại:</strong> {{ $studySession->level }} 
            <span class="badge bg-info text-white ms-2">
                {{ $studySession->studyMethod->name }}
            </span>
        </p>

        <!-- Hiển thị câu hỏi -->
        <div class="mb-3">
            @if(!empty($studySession->question))
                <p><strong>Câu hỏi:</strong></p>
                <p class="text-secondary">{{ $studySession->question }}</p>
            @endif
        </div>

        <!-- Điều kiện theo phương pháp học -->
        <form action="{{ route('study-sessions.update', $studySession->id) }}" method="POST" class="mt-3">
            @csrf
            @method('PUT')

            <!-- Phương pháp "Flashcard" -->
            @if($studySession->studyMethod->name === 'Flashcard')
            <div class="mb-3">
                <!-- Hiển thị thông tin Flashcard -->
                <h3 class="text-center">{{ $studySession->vocabulary->word }}</h3>
                <p class="text-center">{{ $studySession->vocabulary->meaning }}</p> <!-- Hiển thị nghĩa từ vựng -->
                <p class="text-center">{{ $studySession->vocabulary->example_sentence }}</p> <!-- Hiển thị câu ví dụ -->
                <div class="mt-3">
                    <strong>Phương pháp học:</strong>
                    <span class="badge bg-info text-white">{{ $studySession->studyMethod->name }}</span>
                </div>
                <div class="mt-3">
                    <strong>Cấp độ hiện tại:</strong> {{ $studySession->level }}
                </div>
            </div>

            <!-- Phương pháp "Nghe và viết lại" -->
            @elseif($studySession->studyMethod->name === 'Nghe và viết lại')
                <div class="mb-3">
                    <p><strong>Nghe từ:</strong></p>
                    <audio controls class="w-100">
                        <source src="{{ asset('audio/' . $studySession->vocabulary->audio_url) }}" type="audio/mpeg">
                        Trình duyệt của bạn không hỗ trợ thẻ audio.
                    </audio>
                </div>
                <div class="form-group">
                    <label for="answer" class="form-label">Viết lại từ:</label>
                    <input 
                        type="text" 
                        name="answer" 
                        id="answer" 
                        class="form-control" 
                        placeholder="Nhập từ bạn nghe được..."
                        required>
                </div>

            <!-- Phương pháp "Điền từ" -->
            @elseif($studySession->studyMethod->name === 'Điền từ')
                <div class="form-group">
                    <label for="answer" class="form-label">Điền từ:</label>
                    <input 
                        type="text" 
                        name="answer" 
                        id="answer" 
                        class="form-control" 
                        placeholder="Nhập từ vào chỗ trống..." 
                        required
                    >
                </div>
                <div class="hint mt-3">
                    @if(session('hint'))
                        <p><strong>Gợi ý:</strong> {{ session('hint') }}</p>
                    @endif
                </div>
                
            @endif

            <!-- Nút gửi câu trả lời -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-paper-plane"></i> Nộp câu trả lời
                </button>
            </div>
        </form>
    </div>
</div>
