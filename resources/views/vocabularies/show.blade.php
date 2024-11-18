<h1>{{ $vocabulary->word }}</h1>
<p>Loại từ: {{ $vocabulary->type }}</p>
<p>Nghĩa: {{ $vocabulary->meaning }}</p>
<p>Phiên âm: {{ $vocabulary->phonetic }}</p>

<audio controls>
    <source src="{{ asset('audio/' . $vocabulary->audio_url) }}" type="audio/mpeg">
    Trình duyệt của bạn không hỗ trợ audio.
</audio>

<h3>Câu ví dụ</h3>
<p>{{ $vocabulary->example_sentence }} - {{ $vocabulary->example_translation }}</p>

<form action="{{ route('study-sessions.store') }}" method="post">
    @csrf
    <input type="hidden" name="vocabulary_id" value="{{ $vocabulary->id }}">  <!-- Truyền id từ vựng -->
    <button type="submit">Bắt đầu học từ này</button>
</form>
