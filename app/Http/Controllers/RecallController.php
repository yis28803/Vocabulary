<?php

namespace App\Http\Controllers;

use App\Models\MasteredVocabulary;
use App\Models\StudySession;

class RecallController extends Controller
{
    public function recallVocabulary($vocabularyId)
    {
        $studySession = StudySession::where('vocabulary_id', $vocabularyId)->first();

        if ($studySession->level >= 5) {
            MasteredVocabulary::create([
                'user_id' => $studySession->user_id,
                'vocabulary_id' => $vocabularyId,
                'mastered_at' => now(),
            ]);

            $studySession->delete();
            return response()->json(['message' => 'Vocabulary mastered and moved to mastered list.']);
        }

        return response()->json(['message' => 'Vocabulary has not reached mastery level yet.']);
    }
}
