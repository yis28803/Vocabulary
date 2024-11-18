<h1>Chủ đề: {{ $topic->name }}</h1>
<h2>Từ vựng</h2>
<ul>
    @foreach($topic->vocabularies as $vocabulary)
        <li><a href="{{ route('vocabularies.show', $vocabulary->id) }}">{{ $vocabulary->word }}</a></li>
    @endforeach
</ul>
