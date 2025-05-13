<?php

namespace Database\Seeders;

use App\Models\Advertisement;
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
        User::factory()->hasAdvertisements(2)->count(30)->create();
    }
}
