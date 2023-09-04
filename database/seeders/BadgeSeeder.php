<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BadgeSeeder extends Seeder
{
 
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Badge::factory()->count(10)->create(); 
        Badge::create([
            'name' => 'Beginner',
            'description' => 'Achieve Beginner badge.',
        ]);
    
        Badge::create([
            'name' => 'Intermediate',
            'description' => 'Achieve Intermediate badge.',
        ]);
    
        Badge::create([
            'name' => 'Advanced',
            'description' => 'Achieve Advanced badge.',
        ]);
    
        Badge::create([
            'name' => 'Master',
            'description' => 'Achieve Master badge.',
        ]);
    }
}
