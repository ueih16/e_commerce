<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
          [
              'name' => 'Admin',
              'email' => 'hieu81776@gmail.com',
              'email_verified_at' => now(),
              'password' => bcrypt('123123123'),
              'is_admin' => true,
          ],
          [
              'name' => 'Hieu Admin',
              'email' => 'nmhieu16@gmail.com',
              'email_verified_at' => now(),
              'password' => bcrypt('123123123'),
              'is_admin' => true,
          ],
        ];

        foreach($data as $user) {
            User::create($user);
        }
    }
}
