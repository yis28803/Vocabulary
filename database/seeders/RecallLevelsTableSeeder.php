<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RecallLevel;

class RecallLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        RecallLevel::create(['level' => 1, 'time_to_next_level' => 60]); // 1 giờ
        RecallLevel::create(['level' => 2, 'time_to_next_level' => 480]); // 8 giờ
        // Thêm các cấp độ khác...
    }
}
