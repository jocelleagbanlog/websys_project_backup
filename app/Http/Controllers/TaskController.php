<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\Category;

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

    public function edit($id)
    {
        $task = Task::findOrFail($id);

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
}
    // public function edit($id)
    // {
    //     $task = Task::findOrFail($id);
    //     return view('tasks.edit',compact('task'));
    // }

    // public function destroy($id)
    // {
    //     $task = Task::findOrFail($id);
    //     $task->delete();

    //     return redirect()->route('tasks.index')
    //     ->with('success','Task deleted successfully');
    // }

    //     public function index(Request $request)
// {
//     // $query = DB::table('tasks');
//     $query = Task::with('category')
//     ->where('user_id', session('user_id'));

//     // SEARCH
//     if($request->search){
//         $query->where('title','like','%'.$request->search.'%');
//     }

//     // CATEGORY FILTER
//     if($request->category){
//         // $query->where('category',$request->category);\
//         $query->where('category_id',$request->category);
//     }

//     // STATUS FILTER
//     if($request->filter){
//         $query->where('status',$request->filter);
//     }

// //     $tasks = $query->get();

// //     // ✅ GET ALL TASKS FOR COUNTS (IMPORTANT)
// //     $categories = Category::where('user_id', session('user_id'))->get();

// // return view('tasks.index', compact('tasks','allTasks','categories'));
// $tasks = $query->get();

// // ✅ define it
// // $allTasks = DB::table('tasks')->get();
// $allTasks = Task::where('user_id', session('user_id'))->get();

// $categories = Category::where('user_id', session('user_id'))->get();

// return view('tasks.index', compact('tasks','allTasks','categories'));
// }

//     public function index(Request $request)
//     {
//     $baseQuery = Task::where('user_id', session('user_id'));

//     // clone for counts
//     $allTasks = $baseQuery->get();

//     $query = Task::where('user_id', session('user_id'));

//     // STATUS FILTER
//     if ($request->filter) {
//         $query->where('status', $request->filter);
//     }

//     // CATEGORY FILTER
//     if ($request->category) {
//         $query->where('category', $request->category);
//     }

//     // SEARCH
//     if ($request->search) {
//         $query->where('title', 'like', '%' . $request->search . '%');
//     }

//     $tasks = $query->get();

//     return view('tasks.index', compact('tasks', 'allTasks'));
// }
    //     $query = Task::where('user_id', session('user_id'));

    //     // STATUS FILTER
    //     if ($request->filter == 'completed') {
    //         $query->where('status', 'completed');
    //     } elseif ($request->filter == 'ongoing') {
    //         $query->where('status', 'ongoing');
    //     } elseif ($request->filter == 'pending') {
    //         $query->where('status', 'pending');
    //     }

    //     // CATEGORY FILTER
    //     if ($request->category) {
    //         $query->where('category', $request->category);
    //     }

    //     // SEARCH
    //     if ($request->search) {
    //         $query->where('title', 'like', '%' . $request->search . '%');
    //     }

    //     $tasks = $query->get();

    //     return view('tasks.index', compact('tasks'));
    // }

    // public function index()
    // {
    //     $tasks = Task::where('user_id', session('user_id'))->get();
    //     return view('tasks.index',compact('tasks'));
    // }

    // public function create()
    // {
    //     return view('tasks.create');
    // }
