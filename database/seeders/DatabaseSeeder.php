<?php
// database/seeders/DatabaseSeeder.php

use App\Models\Program;
use App\Models\Course;
use App\Models\User;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Database\Factories\ProgramFactory;
use Database\Factories\CourseFactory;
use Database\Factories\UserFactory;
use Database\Factories\StudentFactory;
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed programs first
        // Program::factory()->count(5)->create()->each(function ($program) {
        //     // For each program, seed courses
        //     $program->courses()->saveMany(Course::factory()->count(3)->create());
        // });

        // Seed users
        User::factory()->count(100)->create()->each(function ($user) {
            // For each user, seed a student
            Student::factory()->create(['user_id' => $user->id]);
        });
    }
}
