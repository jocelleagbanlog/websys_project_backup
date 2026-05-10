<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
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

    public function index()
    {
        return redirect()->route('dashboard');
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project = Project::create([
            'owner_id'    => auth()->id(),
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('projects.show', $project);
    }

    public function show(Project $project)
    {
        $this->authorizeProject($project);

        $project->load('tasks.subtasks.assignee', 'members', 'owner');

        return view('projects.show', compact('project'));
    }
}
