<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Gọi tất cả các seeder con mà bạn muốn chạy
        $this->call([
            UserSeeder::class,
            CoursesTableSeeder::class,
            RecallLevelsTableSeeder::class,
            StudyMethodsTableSeeder::class,
            TopicsTableSeeder::class,
            VocabulariesTableSeeder::class,
        ]);
    }
}
