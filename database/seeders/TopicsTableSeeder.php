<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Topic::create(['course_id' => 1, 'name' => 'Schools']);
        Topic::create(['course_id' => 1, 'name' => 'Examination']);
        // Thêm các chủ đề khác...
    }
}
