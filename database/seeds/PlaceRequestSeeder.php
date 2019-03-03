<?php

use Illuminate\Database\Seeder;

class PlaceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 2)->create()->each(function ($user) {
        $user->place_requests()->save(factory(App\PlaceRequest::class)->make());});
	}
}

