<h1>Khóa học: {{ $course->name }}</h1>
<p>Mô tả: {{ $course->description }}</p>
<h2>Chủ đề</h2>
<ul>
    @foreach($course->topics as $topic)
        <li><a href="{{ route('topics.show', $topic->id) }}">{{ $topic->name }}</a></li>
    @endforeach
</ul>
