<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Badge;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BadgeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Badge::factory(50)->create();
        $users = User::all();
        $badges = Badge::all();

        // Assign badges to users (customize this logic as needed)
        $users->each(function ($user) use ($badges) {
            $user->badges()->attach($badges->random());
        });
    }
}
