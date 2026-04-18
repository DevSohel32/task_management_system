<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
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

    public function task_store(StoreTaskRequest $request){
        $data=$request->validated();
        $data['user_id']=Auth::user()->id;
        $task = Task::create($data);
        return with('success', 'Task created successfully!');
    }

    public function task_update(StoreTaskRequest $request, $id){
        $data=$request->validated();
        $task = Task::findOrFail($id);
        $task->update($data);
        return with('success', 'Task updated successfully!');
    }
    public function task_destroy($id){
        $task = Task::findOrFail($id);
        $task->delete();
        return with('success', 'Task deleted successfully!');
    }

    public function status_update($id){
        $task = Task::findOrFail($id);
        $task->status = $task->status === 'completed' ? 'pending' : 'completed';
        $task->save();
        return with('success', 'Task status updated successfully!');
    }
}
