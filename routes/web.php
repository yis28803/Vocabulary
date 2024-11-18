<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\VocabularyController;
use App\Http\Controllers\StudySessionController;
use App\Http\Controllers\RecallController;
use App\Http\Controllers\StudyCardController;


// Route cho trang chủ
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route cho khóa học
Route::get('/courses', [CourseController::class, 'index']); // Hiển thị danh sách khóa học
Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show'); // Chi tiết khóa học

// Route cho chủ đề trong khóa học
Route::get('/courses/{courseId}/topics', [TopicController::class, 'index'])->name('courses.topics'); // Hiển thị danh sách chủ đề theo khóa học
Route::get('/topics/{id}', [TopicController::class, 'show'])->name('topics.show'); // Chi tiết chủ đề

// Route cho từ vựng trong chủ đề
Route::get('/topics/{topicId}/vocabularies', [VocabularyController::class, 'index'])->name('topics.vocabularies'); // Hiển thị từ vựng theo chủ đề
Route::get('/vocabularies/{id}', [VocabularyController::class, 'show'])->name('vocabularies.show'); // Chi tiết từ vựng

// Route cho session học từ vựng
Route::post('/study-sessions', [StudySessionController::class, 'store'])->name('study-sessions.store'); // Tạo mới session học
Route::get('/study-sessions', [StudySessionController::class, 'index'])->name('study-sessions.index');
Route::get('/study-sessions/{id}', [StudySessionController::class, 'show'])->name('study-sessions.show');
Route::put('/study-sessions/{id}', [StudySessionController::class, 'update'])->name('study-sessions.update');

// Route cho recall từ vựng (ốn tập)
Route::post('/recall/{vocabularyId}', [RecallController::class, 'recallVocabulary'])->name('recall.vocabulary'); // Gọi lại từ vựng


Route::get('/study-card/index/{studySessionId}', [StudyCardController::class, 'index'])->name('study-card.index');
Route::get('/study-card/show/{studySessionId}', [StudyCardController::class, 'show'])->name('study-card.show');
Route::get('/study-card/show-all', [StudyCardController::class, 'showAll'])->name('study-card.showAll');
// Route::get('/study-card/exam', [StudyCardController::class, 'exam'])->name('study-card.exam');
Route::post('/study-card/create', [StudyCardController::class, 'create'])->name('study-card.create');
Route::put('/study-card/{id}', [StudyCardController::class, 'update'])->name('study-card.update');

// Route::get('/study-card/{id}', [StudySessionController::class, 'show'])->name('study-card.show');




// Route::post('/study-sessions-kt2', [StudySessionController::class, 'store'])->name('study-sessions-kt2.store');
// Route::get('/study-sessions-kt2', [StudySessionController::class, 'index'])->name('study-sessions-kt2.index');
// Route::get('/study-sessions-kt2/{id}', [StudySessionController::class, 'show'])->name('study-sessions-kt2.show');
// Route::put('/study-sessions-kt2/{id}', [StudySessionController::class, 'update'])->name('study-sessions-kt2.update');