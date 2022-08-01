<?php

namespace App\Console\Commands;

use App\Mail\TasKExpiryEmail;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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

        $now =  Carbon::now()->format('Y-m-d H:i:s');

        $users = User::whereHas('tasks', function ($q) use ($now) {
            $q->where('expiration', '<', $now);
        })->get();

        $users->each(function ($user) use ($now) {
            $tasks = [];
            $userTasks = $user->tasks()->where('expiration', '<', $now)->get();

            Mail::send(new TasKExpiryEmail($user, $userTasks));
            sleep(5);
        });
    }
}
