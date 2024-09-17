<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'debali',
                'username' => 'debali',
                'password' => bcrypt('asdasdasd')
            ],
            [
                'name' => 'nirmala',
                'username' => 'nirmala',
                'password' => bcrypt('asdasdasd')
            ]
        ];

        foreach ($users as $key => $user) {
            User::updateOrCreate([
                'username' => $user['username']
            ],$user);
        }
    }
}
