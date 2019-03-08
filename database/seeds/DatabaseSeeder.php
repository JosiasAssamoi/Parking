<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

      // decommenter pour creer des users random
     // $this->call(UserSeeder::class);


        DB::table('users')->insert([
        'name' => "Assamoi",
        'email' =>"test@gmail.com",
        'firstname' => "Josias",
        'adresse' => "11 rue de poirote",
        'city' => "Poirote-ville",
        'postal_code' => "93500",
        'email_verified_at' => now(),
        'password' => '$2y$10$NhWYjzwvQZh369L4pdj5n.L6KDnDOek0RhcrQRwGu3dTG0WzOSoHC', // secret
        'remember_token' => str_random(10),
        ]);


      $this->call(PlaceSeeder::class);
      $this->call(PlaceRequestSeeder::class);
        
        
    }
}
