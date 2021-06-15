<?php

namespace Database\Factories;

use App\Models\InvoiceDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity' => $this->faker->randomFloat(1, 20, 30),
        ];
    }
}
