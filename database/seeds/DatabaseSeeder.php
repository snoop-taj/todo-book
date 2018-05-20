<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $faker = Faker\Factory::create();
        $password = \Illuminate\Support\Facades\Hash::make('test');
        $userId = $faker->randomNumber();

        \App\User::create([
            'id' => $userId,
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => $password
        ]);

        \App\Todo::create([
            'content' => $faker->sentence,
            'user_id' => $userId,
            'visibility' => $faker->randomElement([100, 200])
        ]);
    }
}
