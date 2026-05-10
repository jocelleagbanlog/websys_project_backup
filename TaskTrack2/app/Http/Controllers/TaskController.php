<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function authorizeProject(Project $project)
    {
        $user = auth()->user();

        abort_unless(
            $project->owner_id == $user->id ||
            $project->members()->where('user_id', $user->id)->exists(),
            403
        );
    }

    public function store(Request $request, Project $project)
    {
        $this->authorizeProject($project);

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->tasks()->create($data);

        return back();
    }

    public function update(Request $request, Project $project, Task $task)
    {
        $this->authorizeProject($project);

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:pending,ongoing,completed',
        ]);

        $task->update($data);

        return back();
    }
}
