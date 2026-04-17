<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::query()->updateOrCreate(
            ['username' => 'admin@gmail.com'],
            [
                'usertype' => 'admin',
                'password' => '123456',
                'organization' => 'Test Organization',
            ]
        );
    }
}
