<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create();
        \App\Models\Category::factory(10)->create();
        \App\Models\Products::factory(10)->create();
        \App\Models\Photos::factory(10)->create();
        \App\Models\Favorite::factory()->create();
        \App\Models\Review::factory()->create();

    }
}
