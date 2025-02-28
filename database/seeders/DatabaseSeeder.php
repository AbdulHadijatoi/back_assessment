<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Timesheet;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Truncate tables to avoid duplicate entries when seeding multiple times
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('projects')->truncate();
        DB::table('timesheets')->truncate();
        DB::table('project_user')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create Users
        $users = User::insert([
            [
                'first_name' => 'Abdul',
                'last_name' => 'Hadi',
                'email' => 'abdulhadijatoi@gmail.com',
                'password' => Hash::make('pass1234'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('pass1234'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'Alice',
                'last_name' => 'Johnson',
                'email' => 'alice@example.com',
                'password' => Hash::make('pass1234'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Create Projects
        $projects = Project::insert([
            [
                'name' => 'Project Alpha',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Project Beta',
                'status' => 'on_hold',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Project Gamma',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Assign Users to Projects (Many-to-Many)
        ProjectUser::insert([
            ['user_id' => 1, 'project_id' => 1],
            ['user_id' => 1, 'project_id' => 2],
            ['user_id' => 2, 'project_id' => 2],
            ['user_id' => 2, 'project_id' => 3],
            ['user_id' => 3, 'project_id' => 1],
            ['user_id' => 3, 'project_id' => 3],
        ]);

        // Create Timesheet Entries (One-to-One)
        Timesheet::insert([
            [
                'user_id' => 1,
                'project_id' => 1,
                'task_name' => 'Develop API',
                'date' => '2025-03-01',
                'hours' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 2,
                'project_id' => 2,
                'task_name' => 'UI Design',
                'date' => '2025-03-02',
                'hours' => 6,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 3,
                'project_id' => 3,
                'task_name' => 'Database Optimization',
                'date' => '2025-03-03',
                'hours' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Creating Attributes
        $attributes = [
            ['name' => 'department', 'type' => 'text'],
            ['name' => 'start_date', 'type' => 'date'],
            ['name' => 'end_date', 'type' => 'date'],
        ];

        foreach ($attributes as $attr) {
            Attribute::firstOrCreate($attr);
        }

        // Fetch attributes and projects
        $department = Attribute::where('name', 'department')->first();
        $startDate = Attribute::where('name', 'start_date')->first();
        $endDate = Attribute::where('name', 'end_date')->first();

        $projects = Project::all();

        // Assigning Attribute Values to Projects
        foreach ($projects as $index => $project) {
            AttributeValue::create([
                'attribute_id' => $department->id,
                'entity_id' => $project->id,
                'value' => ($index % 2 == 0) ? 'IT Department' : 'Marketing'
            ]);

            AttributeValue::create([
                'attribute_id' => $startDate->id,
                'entity_id' => $project->id,
                'value' => now()->subDays($index * 10)->format('Y-m-d')
            ]);

            AttributeValue::create([
                'attribute_id' => $endDate->id,
                'entity_id' => $project->id,
                'value' => now()->addDays(30 + ($index * 10))->format('Y-m-d')
            ]);
        }
    }
}
