<?php

namespace Modules\Project\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Project\Models\Project::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name'        => $this->faker->name(),
            'status'      => 'active',
            'owner_id'    => User::factory(),
            'description' => $this->faker->sentence(),
        ];
    }
}
