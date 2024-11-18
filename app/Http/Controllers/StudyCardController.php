<?php

namespace App\Http\Controllers;

use App\Models\StudySession;
use App\Models\StudentCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StudyCardController extends Controller
{
    // Thời gian chờ giữa các cấp độ
    protected $reviewIntervals = [
        1 => 1,      // 1 giờ cho cấp 1 -> 2
        2 => 8,      // 8 giờ cho cấp 2 -> 3
        3 => 24,     // 24 giờ (1 ngày) cho cấp 3 -> 4
        4 => 72,     // 72 giờ (3 ngày) cho cấp 4 -> 5
        5 => 168,    // 168 giờ (7 ngày) cho cấp 5 (hoàn thành)
    ];

    // Trang hiển thị câu hỏi có thêm từ vào danh sách thẻ học không
    public function index($studySessionId)
    {
        $studySession = StudySession::findOrFail($studySessionId);

        return view('study-cards.index', compact('studySession'));
    }

    // Trang hiển thị chi tiết thẻ học
    public function show($studySessionId)
    {
        $studentCard = StudentCard::with('vocabulary')->findOrFail($studySessionId);

        // Kiểm tra nếu `next_review_at` tồn tại và là một chuỗi, chuyển đổi nó thành đối tượng Carbon
        if ($studentCard->next_review_at) {
            $studentCard->next_review_at = Carbon::parse($studentCard->next_review_at);
        }

        // Kiểm tra nếu chưa đến thời gian ôn tập tiếp theo
        if ($studentCard->next_review_at && $studentCard->next_review_at->isFuture()) {
            return redirect()->route('study-card.showAll')
                            ->with('message', 'Chưa đến thời gian ôn tập lại từ này!');
        }

        return view('study-cards.exam', compact('studentCard'));
    }

    // Trang hiển thị tất cả các thẻ học
    public function showAll()
    {
        // Lấy tất cả các StudentCard của người dùng hiện tại
        $studentCards = StudentCard::where('user_id', Auth::id() ?? 1)->get();

        return view('study-cards.show-all', compact('studentCards'));
    }

    // Tạo mới StudentCard khi người dùng chọn "Có"
    public function create(Request $request)
    {
        $studySessionId = $request->input('study_session_id');
        $studySession = StudySession::findOrFail($studySessionId);

        // Kiểm tra xem người dùng đã có StudentCard cho vocabulary này chưa
        $existingCard = StudentCard::where('user_id', Auth::id() ?? 1)
                                ->where('vocabulary_id', $studySession->vocabulary_id)
                                ->first();

        // Nếu thẻ học đã tồn tại, thông báo và không tạo mới
        if ($existingCard) {
            return redirect()->route('study-card.showAll')
                            ->with('message', 'Thẻ học này đã tồn tại trong danh sách thẻ học của bạn.');
        }

        // Tạo một StudentCard mới với các thông tin từ StudySession
        $studentCard = StudentCard::create([
            'user_id' => Auth::id() ?? 1, // Lấy ID người dùng hiện tại
            'vocabulary_id' => $studySession->vocabulary_id, // Lấy vocabulary_id từ StudySession
            'study_method_id' => $studySession->study_method_id, // Lấy study_method_id từ StudySession
            'level' => $studySession->level, // Cấp độ hiện tại
            'last_studied_at' => now(), // Thời gian học lần cuối
            'next_review_at' => $studySession->next_review_at, // Thời gian ôn tập tiếp theo
            'question' => $studySession->question, // Câu hỏi của session
        ]);

        // Chuyển hướng đến trang hiển thị tất cả thẻ học
        return redirect()->route('study-card.showAll')
                        ->with('message', 'Thẻ học đã được thêm vào danh sách của bạn.');
    }



    // Cập nhật session học từ vựng
    public function update(Request $request, $id)
    {
         // Tìm StudentCard theo ID
        $studyCard = StudentCard::findOrFail($id);
        $correctAnswer = "School";

        // Kiểm tra nếu câu trả lời đúng
        if ($request->input('answer') == $correctAnswer) {
            if ($studyCard->level < 5) {
                $interval = $this->reviewIntervals[$studyCard->level];
                $studyCard->level++;
                // Lưu thời gian tiếp theo theo định dạng chuỗi
                $studyCard->next_review_at = Carbon::now()->addHours($interval)->toDateTimeString();
            }
        } else {
            // Nếu câu trả lời sai
            if ($studyCard->level > 1) {
                $studyCard->level--;
            }
            // Lưu thời gian tiếp theo sau 1 giờ dưới dạng chuỗi
            $studyCard->next_review_at = Carbon::now()->addHours(1)->toDateTimeString(); // Chờ 1 giờ nếu trả lời sai
        }

        $studyCard->save();

        // Redirect đến trang study-card.index cùng với studySession ID
        return redirect()->route('study-card.showAll');

        // Tạo thông điệp phản hồi
        // $message = $request->input('answer') == $correctAnswer 
        //             ? 'Đúng! Cấp độ đã được tăng và bạn cần đợi để ôn tập lại.' 
        //             : 'Sai. Cấp độ đã bị giảm và sẽ cần chờ trước khi ôn tập lại.';

        // return redirect()->route('study-sessions.index', $studySession->id)
        //                 ->with('message', $message);
    }
}
