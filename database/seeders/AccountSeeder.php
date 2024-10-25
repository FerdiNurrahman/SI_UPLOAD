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
                'name' => 'Ferdi Nurrahman',
                'password' => Hash::make('ferdi123'), // Password terenkripsi
            ],
            [
                'username' => 'Alifa',
                'email' => 'alifa@gmail.com',
                'name' => 'Alifa Nur Nabila',
                'password' => Hash::make('alifa123'), // Password terenkripsi
            ],
            [
                'username' => 'Ku',
                'email' => 'ku@gmail.com',
                'name' => 'ku',
                'password' => Hash::make('ku12345'), // Password terenkripsi
            ],
        ]);
    }
}
