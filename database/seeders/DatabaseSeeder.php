<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ProjectSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ProjectSeeder::class,
        ]);
    }
}
