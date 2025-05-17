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
        $categories = Category::all();
        User::factory()->count(15)->create();
        User::factory()->has(
            Advertisement::factory()->hasAttached(
                $categories->get(fake()->numberBetween(0, $categories->count()))
            )->count(1)
        )->count(10)->create();
    }
}
