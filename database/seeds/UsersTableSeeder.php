<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      \App\User::create(
        ['name' => 'Georgios Pappas', 'email' => 'ufaethon@gmail.com', 'type' => 'admin', 'password' => Hash::make('11aa11ss')]);
    }
}
