<?php

namespace App\Services;

use App\Models\Task;
use Carbon\Carbon;

class TaskService
{

    public function getDashboardData()
    {
        $now = Carbon::now();
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'completed')->count();

        // Growth calculation
        $thisMonthTasks = Task::whereMonth('created_at', $now->month)->count();
        $lastMonthTasks = Task::whereMonth('created_at', $now->subMonth()->month)->count();
        $monthGrowth = $lastMonthTasks > 0 ? round(($thisMonthTasks - $lastMonthTasks) / $lastMonthTasks * 100) : 0;

        // Overdue tasks
        $overdueTasks = Task::where('status', '!=', 'completed')
            ->whereDate('due_date', '<', \Carbon\Carbon::today())
            ->count();

        return [
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'completionRate' => $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0,
            'monthGrowth' => $monthGrowth,
            'inProgressTasks' => Task::where('status', 'in_progress')->count(),
            'overdueTasks' => $overdueTasks,
            'chartData' => [
                'completed' => $completedTasks,
                'in_progress' => Task::where('status', 'in_progress')->count(),
                'pending'     => Task::where('status', 'pending')->count(),
            ]
        ];
    }
   
}
