<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => 'Service',
            'description' => $this->faker->jobTitle(),
            'price' => $this->faker->randomFloat(1, 20, 30),
        ];
    }

    /**
     * Indicate that the model's type is food.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function food()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'Food',
                'description' => $this->faker->word(),
            ];
        });
    }
}
