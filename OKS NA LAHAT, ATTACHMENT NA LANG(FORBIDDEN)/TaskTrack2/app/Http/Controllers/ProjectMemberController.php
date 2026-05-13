<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function authorizeOwner(Project $project)
    {
        abort_unless($project->owner_id == auth()->id(), 403);
    }

    public function store(Request $request, Project $project)
    {
        $this->authorizeOwner($project);

        $data = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $data['email'])->firstOrFail();

        $project->members()->syncWithoutDetaching([$user->id]);

        return back()->with('success', 'User invited to project.');
    }
}
