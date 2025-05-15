<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advertisement>
 */
class AdvertisementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->generateName(5),
            "description" => fake()->realText(150),
            "price" => fake()->numberBetween(10, 9000),
        ];
    }

    private function generateName(int $minLen)
    {
        $names = fake()->realText(50);
        $token = " ,.!?";
        $name = strtok($names, $token);
        while ($name !== false) {
            $name = strtok($token);
            if (strlen($name) >= $minLen) {
                return $name;
            }
        }
        return $names[0];
    }
}
