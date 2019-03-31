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

        for($i=1 ; $i<=4;$i++){
            DB::table('users')->insert([
            'name' => "test".$i,
            'email' =>$i."@gmail.com",
            'firstname' => "firstname".$i,
            'adresse' => $i." rue du test",
            'city' => "Poirote-ville",
            'postal_code' => "93500",
            'tovalid' => rand(0,1),
            'email_verified_at' => now(),
            'password' => '$2y$10$NhWYjzwvQZh369L4pdj5n.L6KDnDOek0RhcrQRwGu3dTG0WzOSoHC', // secret 123456
            'remember_token' => str_random(10),
            ]);
        }
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
