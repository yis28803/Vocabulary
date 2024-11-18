<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudyMethod;

class StudyMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Các phương pháp học
        StudyMethod::create(['name' => 'Flashcard', 'description' => 'Học từ vựng bằng thẻ nhớ.']);
        StudyMethod::create(['name' => 'Nghe và viết lại', 'description' => 'Nghe phát âm và viết từ vựng.']);
        StudyMethod::create(['name' => 'Chọn nghĩa của từ', 'description' => 'Chọn nghĩa đúng của từ vựng trong một danh sách lựa chọn.']);
        StudyMethod::create(['name' => 'Điền từ', 'description' => 'Điền từ vào chỗ trống trong câu ví dụ.']);
        StudyMethod::create(['name' => 'Chọn nghĩa của từ được gạch chân', 'description' => 'Chọn nghĩa của từ được gạch chân trong câu ví dụ.']);
        // Bạn có thể thêm các phương pháp học khác nếu cần
    }
}
