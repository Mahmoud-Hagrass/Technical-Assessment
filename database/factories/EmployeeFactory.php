<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'name'          => fake()->name() ,
            'email'         => fake()->unique()->safeEmail() ,
            'department_id' => Department::inRandomOrder()->first()->id ?? Department::factory() ,
            'salary'        => fake()->randomFloat(2 , 3000 , 15000) ,
        ];
    }
}
