<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'FName' => $this->faker->userName,
            'LName' => $this->faker->name,
            'Email' => $this->faker->email,
            'Phone' => $this->faker->phoneNumber,
            'Phone1' => $this->faker->phoneNumber,
            'Meter' => rand(20000000, 80000000),
        ];
    }
}
