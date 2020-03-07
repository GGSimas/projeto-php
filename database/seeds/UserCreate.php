<?php

use Illuminate\Database\Seeder;

class UserCreate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@biblioteca.com',
            'password' => Hash::make('123123'),
            'role' => 100
        ]);
    }
}