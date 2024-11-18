<?php

namespace App\Http\Controllers;

use App\Models\StudentCard;
use App\Models\StudySession;
use App\Models\Vocabulary;
use App\Models\StudyMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StudySessionController extends Controller
{

    // Thời gian chờ giữa các cấp độ
    protected $reviewIntervals = [
        1 => 1,      // 1 giờ cho cấp 1 -> 2
        2 => 8,      // 8 giờ cho cấp 2 -> 3
        3 => 24,     // 24 giờ (1 ngày) cho cấp 3 -> 4
        4 => 72,     // 72 giờ (3 ngày) cho cấp 4 -> 5
        5 => 168,    // 168 giờ (7 ngày) cho cấp 5 (hoàn thành)
    ];

    // Tạo mới một session học từ vựng
    // Hàm để tạo câu hỏi dựa trên phương pháp học
    protected function generateQuestionByMethod($vocabulary, $studyMethodId)
    {
        $studyMethod = StudyMethod::findOrFail($studyMethodId);

        switch ($studyMethod->name) {
            case 'Flashcard':
                return "Dịch từ '{$vocabulary->word}' sang tiếng Việt.";

            case 'Nghe và viết lại':
                return "Nghe từ '{$vocabulary->audio_url}' và viết lại cách đọc.";

            case 'Chọn nghĩa của từ':
                return "Chọn nghĩa đúng của từ '{$vocabulary->word}'.";

            case 'Điền từ':
                $sentence = str_replace($vocabulary->word, '___', $vocabulary->example_sentence);
                return "Điền từ vào chỗ trống trong câu: '{$sentence}'";

            case 'Chọn nghĩa của từ được gạch chân':
                $sentence = str_replace($vocabulary->word, "<u>{$vocabulary->word}</u>", $vocabulary->example_sentence);

                // Tạo phương án lựa chọn với một đáp án đúng và hai đáp án sai ngẫu nhiên
                $options = [
                    $vocabulary->meaning, // Đáp án đúng
                    Vocabulary::inRandomOrder()->where('id', '!=', $vocabulary->id)->value('meaning'),
                    Vocabulary::inRandomOrder()->where('id', '!=', $vocabulary->id)->value('meaning'),
                ];
                shuffle($options); // Trộn ngẫu nhiên các lựa chọn

                return "Trong câu: '{$sentence}', từ được gạch chân có nghĩa là:\n(a) {$options[0]}\n(b) {$options[1]}\n(c) {$options[2]}";

            default:
                return "Ôn tập từ vựng: '{$vocabulary->word}'."; // Câu hỏi mặc định
        }
    }


    // Tạo mới một session học từ vựng
    public function store(Request $request)
    {
        $userId = Auth::id() ?? 1;
        $vocabulary = Vocabulary::findOrFail($request->input('vocabulary_id'));

        // Lấy tất cả các phương pháp học
        $studyMethods = StudyMethod::pluck('id', 'name');
        
        // Random chọn một phương pháp học từ danh sách phương pháp có trong database
        $studyMethodName = $studyMethods->keys()->random();
        $studyMethodId = $studyMethods[$studyMethodName];

        // Tạo câu hỏi dựa trên phương pháp học ngẫu nhiên
        $question = $this->generateQuestionByMethod($vocabulary, $studyMethodId);


        $studySession = StudySession::create([
            'vocabulary_id' => $vocabulary->id,
            'user_id' => $userId,
            'study_method_id' => $studyMethodId,
            'level' => 1,
            'question' => $question,
            'audio' => $vocabulary->audio_url,
            'meaning' => $vocabulary->meaning,
        ]);
        
        return redirect()->route('study-sessions.show', $studySession->id);
    }


    // Kiểm tra điều kiện để ôn tập từ vựng
    public function show($id)
    {
        $studySession = StudySession::with('vocabulary')->findOrFail($id);

        // Kiểm tra nếu `next_review_at` tồn tại và là một chuỗi, chuyển đổi nó thành đối tượng Carbon
        if ($studySession->next_review_at) {
            $studySession->next_review_at = Carbon::parse($studySession->next_review_at);
        }

        // Kiểm tra nếu chưa đến thời gian ôn tập tiếp theo
        if ($studySession->next_review_at && $studySession->next_review_at->isFuture()) {
            return redirect()->route('study-sessions.index')
                            ->with('message', 'Chưa đến thời gian ôn tập lại từ này!');
        }

        return view('study-sessions.show', compact('studySession'));
    }

    public function index()
    {
        $studySessions = StudySession::where('user_id', Auth::id() ?? 1)->get();
        return view('study-sessions.index', compact('studySessions'));
    }



    // Cập nhật session học từ vựng
    public function update(Request $request, $id)
    {
         // Tìm StudentCard theo ID
        $studySession = StudySession::findOrFail($id);
        $correctAnswer = 1;

        // Kiểm tra nếu câu trả lời đúng
        if ($request->input('answer') == $correctAnswer) {
            if ($studySession->level < 5) {
                $interval = $this->reviewIntervals[$studySession->level];
                $studySession->level++;
                // Lưu thời gian tiếp theo theo định dạng chuỗi
                $studySession->next_review_at = Carbon::now()->addHours($interval)->toDateTimeString();
            }
        } else {
            // Nếu câu trả lời sai
            if ($studySession->level > 1) {
                $studySession->level--;
            }
            // Lưu thời gian tiếp theo sau 1 giờ dưới dạng chuỗi
            $studySession->next_review_at = Carbon::now()->addHours(1)->toDateTimeString(); // Chờ 1 giờ nếu trả lời sai
        }

        $studySession->save();

        // Redirect đến trang study-card.index cùng với studySession ID
        return redirect()->route('study-card.index', ['studySessionId' => $studySession->id]);

        // Tạo thông điệp phản hồi
        // $message = $request->input('answer') == $correctAnswer 
        //             ? 'Đúng! Cấp độ đã được tăng và bạn cần đợi để ôn tập lại.' 
        //             : 'Sai. Cấp độ đã bị giảm và sẽ cần chờ trước khi ôn tập lại.';

        // return redirect()->route('study-sessions.index', $studySession->id)
        //                 ->with('message', $message);
    }

   
}


