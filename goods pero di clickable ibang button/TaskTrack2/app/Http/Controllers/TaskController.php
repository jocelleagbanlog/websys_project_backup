<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

//     public function update(Request $request, Project $project, Task $task)
// {
//     $this->authorizeProject($project);

//     $data = $request->validate([
//         'title'       => 'required|string|max:255',
//         'description' => 'nullable|string',
//         'status'      => 'required|in:pending,ongoing,completed',
//         'file'        => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:20480',
//     ]);

//     $task->update([
//         'title'       => $data['title'],
//         'description' => $data['description'],
//         'status'      => $data['status'],
//     ]);

//     // FILE UPLOAD
//     if ($request->hasFile('file')) {

//         foreach ($task->subtasks as $subtask) {
//             foreach ($subtask->attachments ?? [] as $attachment) {
//                 \Storage::disk('public')->delete($attachment->file_path);
//                 $attachment->delete();
//             }
//         }

//         $file = $request->file('file');
//         $path = $file->store('attachments', 'public');

//         $task->attachments()->create([
//             'file_path'     => $path,
//             'original_name' => $file->getClientOriginalName(),
//             'mime_type'     => $file->getClientMimeType(),
//             'size'          => $file->getSize(),
//         ]);
//     }

//     return redirect()->route('projects.show', $project)
//         ->with('success', 'Task updated successfully.');
// }

public function update(Request $request, Project $project, Task $task)
{
    $this->authorizeProject($project);

    $data = $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'file'        => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:20480',
    ]);

    $task->update([
        'title'       => $data['title'],
        'description' => $data['description'],
    ]);

    // FILE UPLOAD
    if ($request->hasFile('file')) {

        foreach ($task->subtasks as $subtask) {
            foreach ($subtask->attachments ?? [] as $attachment) {
                \Storage::disk('public')->delete($attachment->file_path);
                $attachment->delete();
            }
        }

        $file = $request->file('file');
        $path = $file->store('attachments', 'public');

        $task->attachments()->create([
            'file_path'     => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type'     => $file->getClientMimeType(),
            'size'          => $file->getSize(),
        ]);
    }

    return redirect()->route('projects.show', $project)
        ->with('success', 'Task updated successfully.');
}

    public function edit($projectId, $taskId)
{
    $project = Project::findOrFail($projectId);
    $task = Task::findOrFail($taskId);

    return view('projects.edit_tasks', compact('project', 'task'));
}

public function destroy(Project $project, Task $task)
{
    $this->authorizeProject($project);

    if ($task->project_id !== $project->id) {
        abort(403);
    }

    $task->delete();

    return redirect()->route('projects.show', $project)
        ->with('success', 'Task deleted successfully.');
}


}
