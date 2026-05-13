<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
{
    $user = auth()->user();

    $projects = Project::where(function ($query) use ($user) {
            $query->where('owner_id', $user->id)
                  ->orWhereHas('members', function ($q) use ($user) {
                      $q->where('user_id', $user->id);
                  });
        })
        ->when($request->search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        })
        ->with('tasks.subtasks')
        ->get();

    return view('dashboard', compact('user', 'projects'));
}
}
