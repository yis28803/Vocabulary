<h1>Danh sách Khóa học</h1>
<ul>
    @foreach($courses as $course)
        <li><a href="{{ route('courses.show', $course->id) }}">{{ $course->name }}</a></li>
    @endforeach
</ul>
