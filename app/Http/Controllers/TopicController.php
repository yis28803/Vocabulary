<?php

namespace App\Http\Controllers;

use App\Models\Topic;

class TopicController extends Controller
{
    // Hiển thị danh sách chủ đề trong một khóa học
    public function index($courseId)
    {
        $topics = Topic::where('course_id', $courseId)->get(); // Lấy các chủ đề thuộc khóa học
        return view('topics.index', compact('topics', 'courseId')); // Truyền dữ liệu chủ đề tới view
    }

    // Hiển thị chi tiết chủ đề và các từ vựng trong chủ đề
    public function show($id)
    {
        $topic = Topic::with('vocabularies')->findOrFail($id); // Tìm chủ đề cùng các từ vựng
        return view('topics.show', compact('topic')); // Truyền dữ liệu chủ đề tới view
    }
}
