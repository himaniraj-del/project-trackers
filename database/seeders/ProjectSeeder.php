<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Task;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        Project::factory()->count(5)->create()->each(function($project){
            Task::factory()->count(4)->create(['project_id' => $project->id]);
        });
    }
}
