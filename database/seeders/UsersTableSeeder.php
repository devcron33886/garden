<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Jean Paul Byiringiro",
            'email' => 'jeanpaulbyiringiro9764@gmail.com',
            'user_name' => 'jeanpaulbyiringiro9764@gmail.com',
            'role' => \App\Role::SUPER_ADMIN,
            'password' => bcrypt('password'),
        ]);
    }
}
