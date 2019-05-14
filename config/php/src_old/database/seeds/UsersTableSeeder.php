<?php

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
          'name' => "Admin",
          'is_admin' => true,
          'email' => "admin@easyphpgallery.io",
          'password' => bcrypt('secret'),
      ]);

      DB::table('folders')->insert([
          'user_id' => 1,
          'directory' => '/',
          'access_level' => 'R'
      ]);
    }
}
