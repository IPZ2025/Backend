<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //TODO
        // User::factory()->count(30)->create();
        // User::factory()->has(Advertisement::factory())->count(30)->create();
        User::factory()->has(
            Advertisement::factory()->hasAttached(
                Category::where("id", fake()->numberBetween(0, 20))->get()
            )->count(2)
        )->count(30)->create();
    }
}
