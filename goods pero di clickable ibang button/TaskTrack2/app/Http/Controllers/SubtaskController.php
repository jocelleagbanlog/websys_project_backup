<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Subtask;
use Illuminate\Http\Request;

class SubtaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function authorizeTask(Task $task)
    {
        $project = $task->project;
        $user = auth()->user();

        abort_unless(
            $project->owner_id == $user->id ||
            $project->members()->where('user_id', $user->id)->exists(),
            403
        );
    }

    public function store(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task->subtasks()->create($data);

        return back();
    }

    public function update(Request $request, Task $task, Subtask $subtask)
{
    $this->authorizeTask($task);

    $data = $request->validate([
        'title' => 'required|string|max:255',
        'assigned_to' => 'nullable|exists:users,id',
    ]);

    $subtask->update([
        'title' => $data['title'],
        'assigned_to' => $data['assigned_to'] ?? null,
    ]);

    return back()->with('success', 'Subtask updated successfully.');
}

public function destroy(Task $task, Subtask $subtask)
{
    $this->authorizeTask($task);

    if ($subtask->task_id !== $task->id) {
        abort(403);
    }

    $subtask->delete();

    return back()->with('success', 'Subtask deleted successfully.');
}
    
}
