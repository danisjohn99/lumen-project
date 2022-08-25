<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Danis John', 
            'user_name' => 'danis99', 
            'email' => 'danisjohn99@gmail.com',
            'password' => Hash::make('123456789')
        ]);
    }
}
