<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::create(array(
            'name'     => 'Yi Lu',
            'email'    => 'luyibest001@gmail.com',
            'password' => \Hash::make('admin'),
        ));
    }
}