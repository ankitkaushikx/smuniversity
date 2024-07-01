<?php 
// database/factories/CourseFactory.php
namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        return [
            'program_id' => function () {
                return \App\Models\Program::factory()->create()->id;
            },
            'name' => $this->faker->sentence(1),
            'eligibility' => $this->faker->numberBetween(1, 10),
            'duration' => $this->faker->numberBetween(1, 12),
            'banner' => $this->faker->imageUrl(), // Example of a URL for a banner image
            'description' => $this->faker->paragraph,
            'comment' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
