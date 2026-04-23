<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Task</title>

<style>
body { 
    margin:0; 
    font-family:'Segoe UI', Arial; 
    display:flex; 
    background:#f4f6f9;
}

.sidebar {
    width:230px;
    background:linear-gradient(135deg,#f39c12,#f7b267);
    color:white;
    height:100vh;
    padding:20px;
    position:fixed;
}

.main {
    flex:1;
    margin-left:270px;
    padding:20px;
}

.banner {
    background:linear-gradient(135deg,#f39c12,#f7b267);
    color:white;
    padding:20px;
    border-radius:15px;
    margin-bottom:20px;
}

.form-card {
    background:white;
    padding:25px;
    border-radius:12px;
    width:100%;
    max-width:500px;
    margin:40px auto;
    box-shadow:0 3px 10px rgba(0,0,0,0.05);
}

input, textarea, select {
    width:95%;
    padding:10px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid #ddd;
}

button {
    background:linear-gradient(135deg,#f39c12,#f7b267);
    color:white;
    padding:10px;
    border:none;
    border-radius:8px;
    width:100%;
}

/* progress */
.progress-bar {
    width:100%;
    height:8px;
    background:#eee;
    border-radius:10px;
    overflow:hidden;
}

.progress-fill {
    height:100%;
    background:#f39c12;
    transition:0.3s;
}

.subtask-box {
    margin-top:15px;
    padding:10px;
    border-top:1px solid #ddd;
}

.subtask-item {
    display:flex;
    justify-content:space-between;
    padding:5px 0;
}

.back {
    display:inline-block;
    margin-top:10px;
    color:white;
    text-decoration:none;
}
</style>
</head>

<body>

<div class="sidebar">
    <a href="{{ route('tasks.index') }}" class="back">⬅ Back</a>
    <h2>TaskTrack</h2>
</div>

<div class="main">

<div class="banner">
    <h2>Edit Task</h2>
    <p>Update your task information</p>
</div>

<div class="form-card">

@if($errors->any())
    @foreach($errors->all() as $error)
        <p style="color:red">{{ $error }}</p>
    @endforeach
@endif

<!-- MAIN TASK UPDATE FORM -->
<form method="POST" action="{{ route('tasks.update',$task->id) }}">
@csrf

<input type="text" name="title" value="{{ $task->title }}">

<textarea name="description">{{ $task->description }}</textarea>

<select name="category_id">
    @foreach($categories as $cat)
        <option value="{{ $cat->id }}"
            {{ $task->category_id == $cat->id ? 'selected' : '' }}>
            {{ $cat->name }}
        </option>
    @endforeach
</select>

<!-- SUBTASK SECTION (NOT INSIDE FORM) -->
</form>

<div class="subtask-box">

<h3>Subtasks</h3>

<!-- ADD SUBTASK -->
<form method="POST" action="{{ route('subtask.add',$task->id) }}">
@csrf
<input type="text" name="title" placeholder="New subtask..." style="width:75%;">
<button type="submit" style="width:20%;">Add</button>
</form>

<!-- LIST SUBTASKS -->
@if($task->subtasks)
    @foreach($task->subtasks as $sub)
        <div class="subtask-item">
            <div>
                <a href="{{ route('subtask.toggle',$sub->id) }}">
                    {{ $sub->is_done ? '✅' : '⬜' }}
                </a>
                {{ $sub->title }}
            </div>
        </div>
    @endforeach
@endif

@php
$total = $task->subtasks->count();
$done = $task->subtasks->where('is_done', true)->count();
$percent = $total > 0 ? ($done / $total) * 100 : 0;
@endphp

<div style="margin-top:15px;">
    <small>{{ round($percent) }}% completed</small>

    <div class="progress-bar">
        <div class="progress-fill" style="width:{{ $percent }}%;"></div>
    </div>

    <small>{{ $done }} / {{ $total }} subtasks</small>
</div>

</div>

<!-- CONTINUE MAIN FORM -->
<form method="POST" action="{{ route('tasks.update',$task->id) }}">
@csrf

<select name="status">
    <option value="pending" {{ $task->status=='pending'?'selected':'' }}>Pending</option>
    <option value="ongoing" {{ $task->status=='ongoing'?'selected':'' }}>Ongoing</option>
    <option value="completed" {{ $task->status=='completed'?'selected':'' }}>Completed</option>
</select>

<select name="priority">
    <option value="low" {{ $task->priority=='low'?'selected':'' }}>Low</option>
    <option value="medium" {{ $task->priority=='medium'?'selected':'' }}>Medium</option>
    <option value="high" {{ $task->priority=='high'?'selected':'' }}>High</option>
</select>

<button type="submit">Update Task</button>

</form>

</div>
</div>

</body>
</html>