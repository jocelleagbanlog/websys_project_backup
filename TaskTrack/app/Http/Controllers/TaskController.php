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
        $userId = session('user_id'); // yung currently naka login

        $query = Task::with('category')
            ->where('user_id', $userId); // kukunin lang yung tasks under sa user na yun

        // search
        if ($request->search) { // kung may laman lang ska magwowork yung filter
            $query->where('title', 'like', '%' . $request->search . '%'); // % - any character, %exam%, may exam lang lalabas
        }

        // category filter
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        // status filter
        if ($request->filter) {
            $query->where('status', $request->filter);
        }

        $tasks = $query->get();

        // dashboard count, nakafilter din per user, pag $tasks = Task::all(); lalabas lahat
        $allTasks = Task::where('user_id', $userId)->get();

        $tasks = Task::with('subtasks')->get();

        $categories = Category::where('user_id', $userId) // category na nakaseparate per user, kung wala to lalabas lahat ng tasks sa lahat ng user
            ->withCount(['tasks' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            }])
            ->get();

        return view('tasks.index', compact('tasks', 'allTasks', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('user_id', session('user_id'))->get(); 
        return view('tasks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'category_id'=>'required',
            'priority'=>'required'
        ]);

        Task::create([
            'user_id'=>session('user_id'),
            'title'=>$request->title,
            'description'=>$request->description,
            'category_id'=>$request->category_id,
            'status'=>$request->status ?? 'pending',
            'priority'=>$request->priority
        ]);

        return redirect()->route('tasks.index')
        ->with('success','Task created successfully.');
    }

    // public function edit($id)
    // {
    //     $task = Task::findOrFail($id);

    //     $categories = Category::where('user_id', session('user_id'))->get();

    //     return view('tasks.edit', compact('task','categories'));
    // }
    
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
        Subtask::create([
            'task_id' => $taskId,
            'title' => $request->title
        ]);

        return back()->with('success','Subtask added');
    }

    public function toggleSubtask($id)
    {
        $sub = Subtask::findOrFail($id);
        $sub->is_done = !$sub->is_done;
        $sub->save();

        return back();
    }
}
    