<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function index() {
        $categories = Category::with('tasks')->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Category::create([
            'user_id' => session('user_id'),
            'name' => $request->name
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Category added!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,'.$id.',id,user_id,'.session('user_id')
        ]);

        $category = Category::findOrFail($id);
        $category->update(['name'=>$request->name]);

        return redirect()->route('categories.index')
        ->with('success','Category updated');
    }

    public function destroy($id)
    {
        $userId = session('user_id');

        $category = Category::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if ($category) {
            Task::where('category_id', $id)
                ->where('user_id', $userId)
                ->delete();

            $category->delete();
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Category deleted successfully.');
    }
}
