<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

  public function index()
{
    $stats = $this->taskService->getDashboardData();
    $allTasks = Task::latest()->limit(10)->get();

    $teamMembers = User::withCount([
        'tasks as completed_tasks_count' => function ($query) {
            $query->where('status', 'completed');
        },
        'tasks as total_tasks_count',
    ])->get()->map(function ($user) {
        $user->rate = $user->total_tasks_count > 0
            ? round(($user->completed_tasks_count / $user->total_tasks_count) * 100)
            : 0;

        return $user;
    });

    return view('dashboard', array_merge($stats, compact('allTasks', 'teamMembers')));
}
   public function downloadPDF(Request $request, TaskService $taskService)
{
    $data = $taskService->getTaskReportData();
    $data['chartImage'] = $request->input('chart_image');
    $pdf = Pdf::loadView('tasksPDF.index', $data);

    return $pdf->setPaper('a4', 'portrait')->download('task-report.pdf');
}
}
