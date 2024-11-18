<div class="container">
    <h1>Danh sách các phiên học từ vựng</h1>
    
    <!-- Hiển thị thông báo nếu có -->
    @if(session('message'))
        <div class="alert alert-warning">
            {{ session('message') }}
        </div>
    @endif

    <ul>
        @foreach($studentCards as $card)
            <li>
                <a href="{{ route('study-card.show', $card->id) }}">
                    Từ vựng: {{ $card->vocabulary->word }} - Cấp độ: {{ $card->level }}
                </a>
            </li>

            <!-- Hiển thị thời gian chờ trước khi ôn tập lại -->
            @if($card->next_review_at && $card->next_review_at->isFuture())
            <p><strong>Bạn có thể ôn tập lại từ này vào:</strong> 
                {{ $card->next_review_at->format('H:i d-m-Y') }} (Còn {{ $card->next_review_at->diffForHumans() }})
            </p>
            @else
                <p><strong>Thời gian ôn tập lại: </strong>Bạn có thể ôn tập từ này ngay bây giờ.</p>
            @endif
        @endforeach
    </ul>
</div>

