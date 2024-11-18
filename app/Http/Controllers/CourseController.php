<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    // Hiển thị danh sách khóa học
    public function index()
    {
        $courses = Course::all(); // Lấy tất cả các khóa học từ database
        return view('courses.index', compact('courses')); // Truyền danh sách khóa học tới view
    }

    // Hiển thị chi tiết khóa học và các chủ đề trong khóa học
    public function show($id)
    {
        $course = Course::with('topics')->findOrFail($id); // Tìm khóa học cùng các chủ đề của nó
        return view('courses.show', compact('course')); // Truyền dữ liệu khóa học tới view
    }
}
