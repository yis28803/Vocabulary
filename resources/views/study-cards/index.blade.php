<div class="container">
    <h1>Thêm từ vựng vào thẻ học</h1>

    <p>Bạn có muốn thêm từ vựng "<strong>{{ $studySession->vocabulary->word }}</strong>" vào thẻ học không?</p>

    <form action="{{ route('study-card.create') }}" method="POST">
        @csrf
        <input type="hidden" name="study_session_id" value="{{ $studySession->id }}">

        <button type="submit" class="btn btn-success">Có</button>
        <a href="{{ route('study-card.showAll', ['studySessionId' => $studySession->id]) }}" class="btn btn-danger">Không</a>
    </form>
</div>
