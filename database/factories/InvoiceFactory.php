<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->randomNumber(5, true),
            'issue_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'subject' => $this->faker->sentence(),
            'is_paid'  => false
        ];
    }

    /**
     * Indicate that the model's is_paid is true.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function is_paid()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_paid'  => true
            ];
        });
    }
}
