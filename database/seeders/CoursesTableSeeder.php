<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Course::create(['name' => '1000 từ cơ bản', 'description' => 'Khóa học dành cho người mới bắt đầu.']);
        Course::create(['name' => 'IELTS cơ bản', 'description' => 'Khóa học từ vựng cho kỳ thi IELTS.']);
        // Thêm các khóa học khác...
    }
}
