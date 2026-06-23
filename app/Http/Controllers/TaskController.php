<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->orderBy('stage')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $task = Task::create($data);

        if ($data['status'] === 'completed') {
            $this->notifyTaskCompleted($task);
        }

        return redirect()->route('tasks.index')->with('success', 'Tâche ajoutée avec succès.');
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        return response()->json($task);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $data = $request->validated();

        if ($data['status'] === 'completed' && $task->status !== 'completed') {
            $data['actual_end_date'] = now()->toDateString();
            $data['progress'] = 100;
            $this->notifyTaskCompleted($task);
        }

        if ($data['status'] === 'in_progress' && $task->status === 'not_started') {
            $data['start_date'] = $data['start_date'] ?? now()->toDateString();
        }

        $task->update($data);

        return redirect()->route('tasks.index')->with('success', 'Tâche modifiée avec succès.');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tâche supprimée avec succès.');
    }

    public function updateProgress(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate(['progress' => 'required|integer|min:0|max:100']);

        $data = ['progress' => $request->progress];

        if ($request->progress >= 100) {
            $data['status'] = 'completed';
            $data['actual_end_date'] = now()->toDateString();
            $this->notifyTaskCompleted($task);
        } elseif ($request->progress > 0) {
            $data['status'] = 'in_progress';
            if (!$task->start_date) {
                $data['start_date'] = now()->toDateString();
            }
        }

        $task->update($data);

        return response()->json(['success' => true, 'progress' => $request->progress]);
    }

    private function notifyTaskCompleted($task)
    {
        NotificationController::create([
            'type' => 'task_completed',
            'title' => 'Tâche terminée',
            'message' => "La tâche « {$task->name} » est terminée.",
        ]);
    }
}
