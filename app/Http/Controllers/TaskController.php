<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{


   public function all_tasks()
{
    $status = [
        'totalTasks'          => Task::count(),
        'totalCompletedTasks'  => Task::where('status', 'completed')->count(),
        'totalPendingTasks'    => Task::where('status', 'pending')->count(),
        'totalInProgressTasks' => Task::where('status', 'in_progress')->count(),
    ];

    $allTasks = Task::with('user')->latest()->paginate(10);

    return view('all_tasks', array_merge(['tasks' => $allTasks], $status));
}
    public function index()
    {
        $userId = Auth::user()->id;
        $tasks = Task::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        $status = [
            'totalTasks' => $tasks->count(),
            'totalCompletedTasks' => $tasks->where('status', 'completed')->count(),
            'totalPendingTasks' => $tasks->where('status', 'pending')->count(),
            'totalInProgressTasks' => $tasks->where('status', 'in_progress')->count(),
        ];
        return view('myTasks', array_merge(['tasks' => $tasks], $status));
    }

    public function task_store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;
        $task = Task::create($data);
        return redirect()->back()->with('success', 'Task created successfully!');
    }

    public function task_update(StoreTaskRequest $request, $id)
    {
        $data = $request->validated();
        $task = Task::findOrFail($id);
        $task->update($data);
        return redirect()->back()->with('success', 'Task updated successfully!');
    }
    public function task_destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->back()->with('success', 'Task deleted successfully!');
    }

    public function status_update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);
        $task->status = $request->status;
        $task->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated to ' . ucfirst(str_replace('_', ' ', $request->status))
        ]);
    }
}
