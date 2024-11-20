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

    protected function generateQuestionByMethod($vocabulary, $studyMethodId)
    {
        $studyMethod = StudyMethod::findOrFail($studyMethodId);

        switch ($studyMethod->name) {
            case 'Flashcard':
                return "";

            case 'Nghe và viết lại':
                return "Nghe và viết lại";

            case 'Điền từ':
                $word = $vocabulary->word;
                $wordLength = strlen($word);
            
                $wordArray = str_split($word);
            
                $hiddenPositions = range(0, $wordLength - 1);
                shuffle($hiddenPositions);
                $hiddenPositions = array_slice($hiddenPositions, 0, ceil($wordLength / 2)); // Giữ lại nửa số vị trí
            
                foreach ($hiddenPositions as $position) {
                    $wordArray[$position] = ' _ ';
                }
            
                $hint = implode('', $wordArray);

                $replacement = str_repeat('_', $wordLength);
                
                
                $sentence = str_ireplace($vocabulary->word, $replacement, $vocabulary->example_sentence);

                return [
                    'question' => "Điền từ vào chỗ trống trong câu: '{$sentence}'",
                    'hint' => $hint,
                ];

            default:
                return "Ôn tập từ vựng: '{$vocabulary->word}'.";
        }
    }




    // Tạo mới một session học từ vựng
    public function store(Request $request)
    {
        $userId = Auth::id() ?? 1;
        $vocabulary = Vocabulary::findOrFail($request->input('vocabulary_id'));

        $studyMethods = StudyMethod::pluck('id', 'name');
        $studyMethodName = $studyMethods->keys()->random();
        $studyMethodId = $studyMethods[$studyMethodName];

        $studyMethodId = 4;

        $generatedData = $this->generateQuestionByMethod($vocabulary, $studyMethodId);
        // Tách riêng câu hỏi và gợi ý
        $question = is_array($generatedData) ? $generatedData['question'] : $generatedData;
        $hint = is_array($generatedData) && isset($generatedData['hint']) ? $generatedData['hint'] : null;

        // dd($question);

        $studySession = StudySession::create([
            'vocabulary_id' => $vocabulary->id,
            'user_id' => $userId,
            'study_method_id' => $studyMethodId,
            'level' => 1,
            'question' => $question,
        ]);

        return redirect()->route('study-sessions.show', $studySession->id)
            ->with([
                'studySession' => $studySession,
                'hint' => $hint ?? null,
            ]);
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

    }

   
}


