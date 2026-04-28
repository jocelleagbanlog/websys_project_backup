<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\Category;
use App\Models\Subtask;

class TaskController extends Controller
{
    public function __construct() // automatic magwork pag gumamit ng controller
    {
        if (!session()->has('user_id')) { // chine-check kung may naka-login na user, pag meron proceed na sa dashboard, pag wala redirect sa login page
            redirect()->route('login')->send();
        }
    }

    public function index(Request $request)
    {
        $userId = session('user_id');

        $query = Task::with(['category','subtasks'])
            ->where('user_id', $userId);

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->filter) {
            $query->where('status', $request->filter);
        }

        $tasks = $query->get();

        $allTasks = Task::where('user_id', $userId)->get();

        $categories = Category::where('user_id', $userId)
            ->withCount(['tasks' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            }])
            ->get();

        return view('tasks.index', compact('tasks','allTasks','categories'));
    }

    public function create()
    {
        $categories = Category::where('user_id', session('user_id'))->get(); 
        return view('tasks.create', compact('categories'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title'=>'required',
    //         'category_id'=>'required',
    //         'priority'=>'required'
    //     ]);

    //     Task::create([
    //         'user_id'=>session('user_id'),
    //         'title'=>$request->title,
    //         'description'=>$request->description,
    //         'category_id'=>$request->category_id,
    //         'status'=>$request->status ?? 'pending',
    //         'priority'=>$request->priority
    //     ]);

    //     if ($request->subtasks) {
    //     foreach ($request->subtasks as $title) {
    //         Subtask::create([
    //             'task_id' => $task->id,
    //             'title' => $title,
    //             'is_done' => false
    //         ]);
    //     }
    // }

    //     return redirect()->route('tasks.index')
    //     ->with('success','Task created successfully.');
    // }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'category_id' => 'required',
        'priority' => 'required'
    ]);

    // create task first
    $task = Task::create([
        'user_id' => session('user_id'),
        'title' => $request->title,
        'description' => $request->description,
        'category_id' => $request->category_id,
        'status' => $request->status ?? 'pending',
        'priority' => $request->priority
    ]);

    // SAVE SUBTASKS HERE
    if ($request->has('subtasks')) {
        foreach ($request->subtasks as $subtaskTitle) {
            if ($subtaskTitle) {
                Subtask::create([
                    'task_id' => $task->id,
                    'title' => $subtaskTitle,
                    'is_done' => false
                ]);
            }
        }
    }

    return redirect()->route('tasks.index')
        ->with('success', 'Task created successfully.');
}
    
    public function edit($id)
    {
        $task = Task::with('subtasks')->findOrFail($id);

        $categories = Category::where('user_id', session('user_id'))->get();

        return view('tasks.edit', compact('task','categories'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'title'=>'required',
            // 'category'=>'required',
            'category_id'=>'required',
            'priority'=>'required'
        ]);

        $task = Task::findOrFail($id);

        $task->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'category_id'=>$request->category_id,
            'status'=>$request->status,
            'priority'=>$request->priority
        ]);

        return redirect()->route('tasks.index')
        ->with('success','Task updated successfully.');
    }

    public function destroy($id)
    {
        $task = Task::where('id', $id)
            ->where('user_id', session('user_id'))
            ->first();

        if ($task) {
            $task->delete();
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    public function addSubtask(Request $request, $taskId)
    {
        $request->validate([
            'title' => 'required'
        ]);

        Subtask::create([
            'task_id' => $taskId,
            'title' => $request->title,
            'is_done' => false
        ]);

        $task = Task::with('subtasks')->find($taskId);

        $total = $task->subtasks->count();
        $done = $task->subtasks->where('is_done', true)->count();

        $task->status = ($total > 0 && $done == $total)
            ? 'completed'
            : 'ongoing';

        $task->save();

        return back()->with('success','Subtask added');
    }

    public function toggleSubtask($id)
    {
        $sub = Subtask::findOrFail($id);

        $sub->is_done = !$sub->is_done;
        $sub->save();

        $task = $sub->task;

        $total = $task->subtasks()->count();
        $done = $task->subtasks()->where('is_done', true)->count();

        if ($done > 0 && $done < $total) {
            $task->status = 'ongoing';
        }

        if ($total > 0 && $done == $total) {
            $task->status = 'completed';
        }

        if ($done == 0) {
            $task->status = 'pending';
        }

        $task->save();

        return back();
    }

    public function updateSubtask(Request $request, $id)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $sub = Subtask::findOrFail($id);
        $sub->title = $request->title;
        $sub->save();

        return back()->with('success', 'Subtask updated successfully.');
    }
}
    