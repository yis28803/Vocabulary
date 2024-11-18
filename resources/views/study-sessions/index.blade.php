<div class="container">
    <h1>Danh sách các phiên học từ vựng</h1>
    
    <!-- Hiển thị thông báo nếu có -->
    @if(session('message'))
        <div class="alert alert-warning">
            {{ session('message') }}
        </div>
    @endif

    <ul>
        @foreach($studySessions as $session)
            <li>
                <a href="{{ route('study-sessions.show', $session->id) }}">
                    Từ vựng: {{ $session->vocabulary->word }} - Cấp độ: {{ $session->level }}
                </a>
            </li>

            <!-- Hiển thị thời gian chờ trước khi ôn tập lại -->
            @if($session->next_review_at && $session->next_review_at->isFuture())
            <p><strong>Bạn có thể ôn tập lại từ này vào:</strong> 
                {{ $session->next_review_at->format('H:i d-m-Y') }} (Còn {{ $session->next_review_at->diffForHumans() }})
            </p>
            @else
                <p><strong>Thời gian ôn tập lại: </strong>Bạn có thể ôn tập từ này ngay bây giờ.</p>
            @endif
        @endforeach
    </ul>
</div>

