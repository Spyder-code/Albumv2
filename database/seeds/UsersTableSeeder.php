<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "almi",
            'phone' => "083857317946",
            'password' => Hash::make('admin123'),
            'level' => 1,
            'image' => "default.jpg",
            'hit' => 0
        ]);
        User::create([
            'name' => "aziz",
            'phone' => "083857317946",
            'password' => Hash::make('admin123'),
            'level' => 3,
            'image' => "default.jpg",
            'hit' => 0
        ]);
    }
}
