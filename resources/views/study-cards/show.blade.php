<div class="container">
    <h1>Thông tin thẻ học</h1>

    <p>Thẻ học cho từ vựng "<strong>{{ $studySession->vocabulary->word }}</strong>" đã được tạo.</p>

    <p><strong>Câu hỏi:</strong> {{ $studySession->question }}</p>
    <p><strong>Cấp độ hiện tại:</strong> {{ $studySession->level }}</p>
    <p><strong>Thời gian ôn tập tiếp theo:</strong> {{ $studySession->next_review_at }}</p>

    <!-- Button dẫn tới trang tất cả các thẻ học -->
    <a href="{{ route('study-card.showAll') }}" class="btn btn-primary mt-3">Xem tất cả thẻ học</a>
</div>
