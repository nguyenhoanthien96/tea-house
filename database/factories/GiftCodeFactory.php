<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GiftCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $employeePhone = $this->faker->regexify('09151110[1-9]{2}');
        $storeID = substr($employeePhone, -1); // store id = last number of employee phone

        return [
            'employee_phone' => $employeePhone,
            'point' => mt_rand(1, 9),
            'gift_code' => Str::random(10),
            'store_id' => $storeID,
        ];
    }
}
