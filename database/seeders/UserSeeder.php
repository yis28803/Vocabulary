<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tạo một người dùng admin mẫu
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),  // Mã hóa mật khẩu
        ]);

        // Tạo một người dùng bình thường mẫu
        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password123'),  // Mã hóa mật khẩu
        ]);

        // Tạo thêm người dùng nếu cần thiết
        User::create([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'password' => Hash::make('123456'),  // Mã hóa mật khẩu
        ]);

        // Bạn có thể tạo nhiều người dùng khác tùy theo nhu cầu
    }
}
