<?php

namespace Database\Factories;
use App\Models\Division;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Division>
 */
class DivisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Division::class;
    public function definition(): array
    {
        return [
            'div_name' => $this->faker->unique()->word(),
            'div_desc' => $this->faker->sentence(),
        ];
    }
}
