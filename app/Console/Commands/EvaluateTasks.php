<?php

namespace App\Console\Commands;

use App\Models\Task;
use DateTime;
use Illuminate\Console\Command;

class EvaluateTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'evaluate:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
    }
}
