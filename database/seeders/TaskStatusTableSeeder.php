<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks_status')->insert(
            [
                [
                    'status_name' => 'open',
                ],
                [
                    'status_name' => 'completed',
                ],
                [
                    'status_name' => 'cancelled',
                ]
            ]
        );
    }
}
