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

    // public function index()
    // {
    //     $studySessions = StudySession::where('user_id', Auth::id() ?? 1)->get();
    //     return view('study-sessions.index', compact('studySessions'));
    // }

    protected function generateHint($vocabulary)
    {
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
            'hint' => $hint,
            'question' => "Điền từ vào chỗ trống trong câu: '{$sentence}'"
        ];
    }

    
    public function store(Request $request)
    {
        $userId = Auth::id() ?? 1;
        $vocabulary = Vocabulary::findOrFail($request->input('vocabulary_id'));

        $hintData = $this->generateHint($vocabulary);
        $hint = $hintData['hint'];

        $studySession = StudySession::create([
            'vocabulary_id' => $vocabulary->id,
            'user_id' => $userId,
            'level' => 1,
            'hints' => ['Điền từ' => $hint],
        ]);

        return redirect()->route('study-sessions.show', $studySession->id)
            ->with('hint', $hint);
    }

    public function show($id)
    {
        $studySession = StudySession::with('vocabulary')->findOrFail($id);

        $methods = ['Flashcard', 'Nghe và viết lại', 'Điền từ'];
        $completedMethods = $studySession->completed_methods ?? [];

        foreach ($methods as $method) {
            if (!in_array($method, $completedMethods)) {
                $currentMethod = $method;
                $hint = $studySession->hints[$method] ?? null; // Lấy hint từ database
                break;
            }
        }

        if (empty($currentMethod)) {
            return redirect()->route('study-card.index', ['studySessionId' => $studySession->id]);
        }

        return view('study-sessions.show', compact('studySession', 'currentMethod', 'hint'));
    }


    public function update(Request $request, $studySessionId)
    {
        $studySession = StudySession::findOrFail($studySessionId);

        $currentMethod = $request->input('currentMethod');
        $completedMethods = $studySession->completed_methods ?? [];

        if (!in_array($currentMethod, $completedMethods)) {
            $completedMethods[] = $currentMethod;
            $studySession->update(['completed_methods' => $completedMethods]);
        }

        return redirect()->route('study-sessions.show', $studySessionId);
    }


}