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
        'tovalid' => 0,
        'email_verified_at' => now(),
        'password' => '$2y$10$NhWYjzwvQZh369L4pdj5n.L6KDnDOek0RhcrQRwGu3dTG0WzOSoHC', // secret 123456
        'remember_token' => str_random(10),
        ]);
        DB::table('users')->insert([
        'name' => "Admin",
        'email' =>"admin@admin.fr",
        'firstname' => "Admin",
        'adresse' => "11 rue tout est permis",
        'city' => "SuperMan City",
        'postal_code' => "77777",
        'tovalid' => 0,
        'rules' =>'admin',
        'email_verified_at' => now(),
        'password' => '$2y$10$NhWYjzwvQZh369L4pdj5n.L6KDnDOek0RhcrQRwGu3dTG0WzOSoHC', // secret 123456
        'remember_token' => str_random(10),
        ]);

        $this->call(PlaceSeeder::class);


    }
}
