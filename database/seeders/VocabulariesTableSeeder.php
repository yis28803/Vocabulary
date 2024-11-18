<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vocabulary;

class VocabulariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Thêm từ vựng đầu tiên: School
        Vocabulary::create([
            'topic_id' => 1,
            'word' => 'School',
            'type' => 'noun',
            'meaning' => 'trường học',
            'audio_url' => 'school.mp3',
            'phonetic' => '/skuːl/',
            'example_sentence' => 'I go to school every day.',
            'example_translation' => 'Tôi đi học mỗi ngày.'
        ]);

        // Thêm từ vựng thứ hai: Book
        Vocabulary::create([
            'topic_id' => 1,
            'word' => 'Book',
            'type' => 'noun',
            'meaning' => 'cuốn sách',
            'audio_url' => 'book.mp3',
            'phonetic' => '/bʊk/',
            'example_sentence' => 'I am reading a book.',
            'example_translation' => 'Tôi đang đọc một cuốn sách.'
        ]);

        // Thêm từ vựng thứ ba: Teacher
        Vocabulary::create([
            'topic_id' => 1,
            'word' => 'Teacher',
            'type' => 'noun',
            'meaning' => 'giáo viên',
            'audio_url' => 'teacher.mp3',
            'phonetic' => '/ˈtiːtʃər/',
            'example_sentence' => 'The teacher explains the lesson.',
            'example_translation' => 'Giáo viên giải thích bài học.'
        ]);

        // Thêm từ vựng thứ tư: Classroom
        Vocabulary::create([
            'topic_id' => 1,
            'word' => 'Classroom',
            'type' => 'noun',
            'meaning' => 'phòng học',
            'audio_url' => 'classroom.mp3',
            'phonetic' => '/ˈklɑːsrʊm/',
            'example_sentence' => 'The classroom is clean and organized.',
            'example_translation' => 'Phòng học sạch sẽ và ngăn nắp.'
        ]);

        // Thêm từ vựng thứ năm: Study
        Vocabulary::create([
            'topic_id' => 1,
            'word' => 'Study',
            'type' => 'verb',
            'meaning' => 'học',
            'audio_url' => 'study.mp3',
            'phonetic' => '/ˈstʌdi/',
            'example_sentence' => 'She studies for two hours every day.',
            'example_translation' => 'Cô ấy học hai giờ mỗi ngày.'
        ]);

        // Thêm từ vựng thứ sáu: Computer
        Vocabulary::create([
            'topic_id' => 1,
            'word' => 'Computer',
            'type' => 'noun',
            'meaning' => 'máy tính',
            'audio_url' => 'computer.mp3',
            'phonetic' => '/kəmˈpjuːtər/',
            'example_sentence' => 'I use my computer to do my homework.',
            'example_translation' => 'Tôi sử dụng máy tính để làm bài tập.'
        ]);

        // Thêm từ vựng thứ bảy: Internet
        Vocabulary::create([
            'topic_id' => 1,
            'word' => 'Internet',
            'type' => 'noun',
            'meaning' => 'mạng internet',
            'audio_url' => 'internet.mp3',
            'phonetic' => '/ˈɪntənet/',
            'example_sentence' => 'I need the internet to do research.',
            'example_translation' => 'Tôi cần mạng internet để làm nghiên cứu.'
        ]);

        // Thêm từ vựng thứ tám: Homework
        Vocabulary::create([
            'topic_id' => 1,
            'word' => 'Homework',
            'type' => 'noun',
            'meaning' => 'bài tập về nhà',
            'audio_url' => 'homework.mp3',
            'phonetic' => '/ˈhoʊmwɜːrk/',
            'example_sentence' => 'I have a lot of homework to finish.',
            'example_translation' => 'Tôi có rất nhiều bài tập về nhà để hoàn thành.'
        ]);
    }
}
