<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Course;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CourseSeeder::class,
            LessonSeeder::class,
            ProjectSeeder::class,
            MarkSeeder::class,
        ]);

        // Get all the roles attaching up to 3 random roles to each user
        $courses = Course::all();

        // Populate the pivot table with random courses
        User::all()->each(function ($user) use ($courses) { 
            $user->courses()->attach(
                $courses->random(rand(1, 5))->pluck('id')->toArray()
            ); 
        });

        // Populate all courses for every user
        // User::all()->each(function ($user) use ($courses) { 
        //     $user->courses()->saveMany($courses); 
        // });
    }
}
