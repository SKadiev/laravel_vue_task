<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        $this->call(AdminTestUserSeeder::class);
        $this->call(RegularlTestUserSeeder::class);
        $this->call(TaskStatusTableSeeder::class);
        $this->call(RandomUserTableSeeder::class);
        $this->call(RandomTasksTableSeeder::class);
    }
}
