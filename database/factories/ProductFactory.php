<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => Str::random(50),
            'brand_id' => Brand::factory()->create()->id,
            'category_id' => Category::factory()->create()->id,
            'users_create_id' => User::first() ? User::first()->id : User::factory()->create()->id,
            'users_update_id' => null,
        ];
    }
}
