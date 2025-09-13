<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Carbon\Carbon;

class FlagOverdueTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:flag-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically flag overdue tasks and unflag completed ones';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting overdue task flagging process...');

        // Flag tasks that are overdue but not yet flagged
        $overdueTasksToFlag = Task::where('due_date', '<', Carbon::today())
            ->whereIn('status', ['todo', 'in_progress'])
            ->where('is_flagged_overdue', false)
            ->get();

        $flaggedCount = 0;
        foreach ($overdueTasksToFlag as $task) {
            $task->update(['is_flagged_overdue' => true]);
            $flaggedCount++;
            $this->line("Flagged: {$task->title} (Due: {$task->due_date->format('Y-m-d')})");
        }

        // Unflag tasks that are completed or no longer overdue
        $tasksToUnflag = Task::where(function ($query) {
            $query->where('status', 'done')
                  ->orWhere('due_date', '>=', Carbon::today())
                  ->orWhereNull('due_date');
        })->where('is_flagged_overdue', true)->get();

        $unflaggedCount = 0;
        foreach ($tasksToUnflag as $task) {
            $task->update(['is_flagged_overdue' => false]);
            $unflaggedCount++;
            $this->line("Unflagged: {$task->title} (Status: {$task->status})");
        }

        $this->info("Process completed!");
        $this->info("Tasks flagged as overdue: {$flaggedCount}");
        $this->info("Tasks unflagged: {$unflaggedCount}");

        return Command::SUCCESS;
    }
}
