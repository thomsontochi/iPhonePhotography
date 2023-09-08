<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Achievement;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // $user = User::factory()->count(10)->create(); // Create 10 dummy users
        $user = User::factory()->create();

        // Associate achievements with the user
        $achievements = Achievement::factory()->create();
        $user->achievements()->attach($achievements);
    }
}
