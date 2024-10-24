<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->insert([
            [
                'username' => 'ferdi',
                'email' => 'ferdi@gmail.com',
                'name' => 'User One',
                'password' => Hash::make('ferdi123'), // Password terenkripsi
            ],
            [
                'username' => 'user2',
                'email' => 'user2@example.com',
                'name' => 'User Two',
                'password' => Hash::make('password456'), // Password terenkripsi
            ],
        ]);
    }
}
