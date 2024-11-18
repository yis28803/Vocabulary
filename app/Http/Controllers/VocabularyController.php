<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;

class VocabularyController extends Controller
{
    // Hiển thị danh sách từ vựng trong một chủ đề
    public function index($topicId)
    {
        $vocabularies = Vocabulary::where('topic_id', $topicId)->get(); // Lấy các từ vựng thuộc chủ đề
        return view('vocabularies.index', compact('vocabularies', 'topicId')); // Truyền danh sách từ vựng tới view
    }

    // Hiển thị chi tiết từ vựng
    public function show($id)
    {
        $vocabulary = Vocabulary::findOrFail($id); // Tìm từ vựng
        return view('vocabularies.show', compact('vocabulary')); // Truyền dữ liệu từ vựng tới view
    }
}
