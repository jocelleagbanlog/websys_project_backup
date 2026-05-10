<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use Illuminate\Http\Request;

class SubtaskAttachmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function authorizeSubtask(Subtask $subtask)
    {
        $project = $subtask->task->project;
        $user = auth()->user();

        abort_unless(
            $project->owner_id == $user->id ||
            $project->members()->where('user_id', $user->id)->exists(),
            403
        );
    }

    public function store(Request $request, Subtask $subtask)
    {
        $this->authorizeSubtask($subtask);

        $data = $request->validate([
            'file' => 'required|file|mimes:jpeg,jpg,png,gif,doc,docx,xls,xlsx,pdf|max:20480',
        ]);

        $file = $data['file'];

        $path = $file->store('attachments', 'public');

        $subtask->attachments()->create([
            'file_path'     => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type'     => $file->getClientMimeType(),
            'size'          => $file->getSize(),
        ]);

        return back();
    }
}
