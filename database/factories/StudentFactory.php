<?php
// database/factories/StudentFactory.php
namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        $gender = $this->faker->randomElement(['male', 'female']);

        return [
            'user_id' => User::factory(),
            'center_id' => 1, // Adjust as per your needs
            'student_code' => $this->faker->unique()->numerify('STU#####'),
            'father_name' => $this->faker->name('male'),
            'mother_name' => $this->faker->name('female'),
            'dob' => $this->faker->date(),
            'gender' => $gender,
            'address' => $this->faker->address,
            'comment' => $this->faker->sentence,
            'course_id' => Course::factory(),
            'session_start' => $this->faker->year,
            'session_end' => $this->faker->year,
            'photo' => $this->faker->imageUrl(),
            'id_proof' => $this->faker->imageUrl(), // Assuming this is an image URL
            'tenth' => $this->faker->randomElement([null, 'Passed', 'Failed']),
            'twelfth' => $this->faker->randomElement([null, 'Passed', 'Failed']),
            'diploma' => $this->faker->randomElement([null, 'Completed', 'Not Completed']),
            'undergraduate' => $this->faker->randomElement([null, 'Completed', 'Not Completed']),
            'postgraduate' => $this->faker->randomElement([null, 'Completed', 'Not Completed']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
