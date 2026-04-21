<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required|min:3',
            'email'=>'required|email|unique:system_users',
            'password'=>'required|min:6|confirmed'
        ],[
            'name.required' => 'Name is required.',
            'name.min' => 'Name must be at least 3 characters.',

            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'email.unique' => 'Email already exists.',

            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password does not match.'
        ]);

        DB::table('system_users')->insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'created_at'=>now(),
            'updated_at'=>now()
        ]);

        return redirect()->route('login')
        ->with('success','Account created successfully.');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ], [
            'email.required' => 'Email is required.',
            'password.required' => 'Password is required.'
        ]);

        $user = DB::table('system_users')
            ->where('email',$request->email)
            ->first();

        if($user && Hash::check($request->password,$user->password))
        {
            // dito sinesave kung sino yung naglogin
            session([
                'user_id'=>$user->id, // ginagamit pangfilter ng tasks
                'user_name'=>$user->name
            ]);

            return redirect()->route('tasks.index')
            ->with('success','Login successfully.');
        }

        return back()->with('error','Invalid email or password.');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Hash;
// use App\Models\Task;

// class UserController extends Controller
// {
//     public function __construct()
//     {
//         if (!session()->has('user_id')) {
//             redirect()->route('login')->send();
//         }
//     }

//     public function showRegister()
//     {
//         return view('register');
//     }

//     public function register(Request $request)
//     {

//         $request->validate([
//             'name'=>'required|min:3',
//             'email'=>'required|email|unique:system_users',
//             'password'=>'required|min:6|confirmed'
//         ]);

//         DB::table('system_users')->insert([
//             'name'=>$request->name,
//             'email'=>$request->email,
//             'password'=>Hash::make($request->password),
//             'created_at'=>now(),
//             'updated_at'=>now()
//         ]);

//         return redirect()->route('login')
//         ->with('success','Account created successfully');
//     }

//     public function showLogin()
//     {
//         return view('login');
//     }

//     public function login(Request $request)
// {
//     $request->validate([
//         'email'=>'required|email',
//         'password'=>'required'
//     ]);

//     $user = DB::table('system_users')
//         ->where('email', $request->email)
//         ->first();

//     if ($user && Hash::check($request->password, $user->password)) {

//         // ✅ FIXED SESSION
//         session([
//             'user_id' => $user->id,
//             'user_name' => $user->name
//         ]);

//         // ✅ REDIRECT TO DASHBOARD
//         return redirect()->route('tasks.index')
//             ->with('success', 'Login successful!');
//     }

//     return back()->with('error', 'Invalid email or password');
// }
//         // $user = DB::table('system_users')
//         // ->where('email',$request->email)
//         // ->first();

//         // if($user && Hash::check($request->password,$user->password))
//         // {

//         //     session([
//         //         'user_id'=>$user->id,
//         //         'user_name'=>$user->name
//         //     ]);

//         //     return redirect()->route('tasks.index');
//         // }

//         // return back()->with('error','Invalid email or password');
    

//     public function logout()
//     {
//         session()->flush();
//         return redirect()->route('login');
//     }

//     public function destroy($id)
// {
//     $task = Task::findOrFail($id);

//     // optional: security check
//     if ($task->user_id != session('user_id')) {
//         return redirect()->route('tasks.index');
//     }

//     $task->delete();

//     return redirect()->route('tasks.index')
//         ->with('success', 'Task deleted successfully');
// }
// }