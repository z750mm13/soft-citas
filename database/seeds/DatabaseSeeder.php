<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        DB::table('users')->insert([
            'email' => env('MAIN_EMAIL'),
            'password' => bcrypt(env('FIRST_PASSWD_MAIN_EMAIL')),
            'active' => true,
            'admin' => true,
            'name' => 'Fernando',
            'lastname' => 'Martines',
            'postlastname' => 'Martin',
            'tipo' => 'Integrante',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
