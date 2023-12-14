<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id'       => 1,
                'first_name'    => 'Admin',
            ],
            [
                'user_id'       => 2,
                'first_name'    => 'Hieu',
                'last_name'    => 'Admin',
            ],
        ];
        foreach($data as $user) {
            Customer::create($user);
        }
    }
}
