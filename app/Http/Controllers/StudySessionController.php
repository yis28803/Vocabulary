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
    protected $reviewIntervals = [
        1 => 1,      
        2 => 8,      
        3 => 24,     
        4 => 72,     
        5 => 168,    
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
                $hiddenPositions = array_slice($hiddenPositions, 0, ceil($wordLength / 2));
            
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

    public function index()
    {
        $studySessions = StudySession::where('user_id', Auth::id() ?? 1)->get();
        return view('study-sessions.index', compact('studySessions'));
    }

    public function show($id)
    {
        $studySession = StudySession::with('vocabulary')->findOrFail($id);
        if ($studySession->next_review_at) {
            $studySession->next_review_at = Carbon::parse($studySession->next_review_at);
        }
        if ($studySession->next_review_at && $studySession->next_review_at->isFuture()) {
            return redirect()->route('study-sessions.index')
                            ->with('message', 'Chưa đến thời gian ôn tập lại từ này!');
        }
        return view('study-sessions.show', compact('studySession'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id() ?? 1;
        $vocabulary = Vocabulary::findOrFail($request->input('vocabulary_id'));
        $studyMethods = StudyMethod::pluck('id', 'name');
        $studyMethodName = $studyMethods->keys()->random();
        $studyMethodId = $studyMethods[$studyMethodName];
        $studyMethodId = 4;
        $generatedData = $this->generateQuestionByMethod($vocabulary, $studyMethodId);
        $question = is_array($generatedData) ? $generatedData['question'] : $generatedData;
        $hint = is_array($generatedData) && isset($generatedData['hint']) ? $generatedData['hint'] : null;
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
    public function update(Request $request, $id)
    {
        $studySession = StudySession::findOrFail($id);
        $correctAnswer = 1;
        if ($request->input('answer') == $correctAnswer) {
            if ($studySession->level < 5) {
                $interval = $this->reviewIntervals[$studySession->level];
                $studySession->level++;
                $studySession->next_review_at = Carbon::now()->addHours($interval)->toDateTimeString();
            }
        } else {
            if ($studySession->level > 1) {
                $studySession->level--;
            }
            $studySession->next_review_at = Carbon::now()->addHours(1)->toDateTimeString(); 
        }
        $studySession->save();
        return redirect()->route('study-card.index', ['studySessionId' => $studySession->id]);
    }
}