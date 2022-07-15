<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'username' => 'Admin',
                'is_admin' => '1',
                'password' => bcrypt('123456'),
            ],
            [
                'username' => 'Abhi',
                'is_admin' => '0',
                'password' => bcrypt('123456'),
            ],
            [
                'username' => 'Sagar',
                'is_admin' => '0',
                'password' => bcrypt('123456'),
            ],
            [
                'username' => 'Sara',
                'is_admin' => '0',
                'password' => bcrypt('123456'),
            ],
            [
                'username' => 'Mehar',
                'is_admin' => '0',
                'password' => bcrypt('123456'),
            ],
            [
                'username' => 'Malu',
                'is_admin' => '0',
                'password' => bcrypt('123456'),
            ],
            [
                'username' => 'Reka',
                'is_admin' => '0',
                'password' => bcrypt('123456'),
            ],
            [
                'username' => 'Minnu',
                'is_admin' => '0',
                'password' => bcrypt('123456'),
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}