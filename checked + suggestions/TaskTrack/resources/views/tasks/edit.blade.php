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

/* SIDEBAR */
.sidebar {
    width:230px;
    background:linear-gradient(135deg,#f39c12,#f7b267);
    color:white;
    height:100vh;
    padding:20px;
    position:fixed;
}

/* MAIN */
.main {
    flex:1;
    margin-left:270px;
    padding:30px;
}

/* HEADER */
.banner {
    background:linear-gradient(135deg,#f39c12,#f7b267);
    color:white;
    padding:25px;
    border-radius:15px;
    margin-bottom:20px;
}

/* CARD */
.form-card {
    background:white;
    padding:25px;
    border-radius:12px;
    max-width:650px;
    margin:auto;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

/* INPUTS */
input, textarea, select {
    width:96%;
    padding:10px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid #ddd;
    outline:none;
}

/* BUTTON */
button {
    background:linear-gradient(135deg,#f39c12,#f7b267);
    color:white;
    padding:10px;
    border:none;
    border-radius:8px;
    cursor:pointer;
}

/* SUBTASK SECTION */
.subtask-box {
    margin-top:25px;
    padding-top:15px;
    border-top:1px solid #eee;
}

/* ADD SUBTASK FORM */
.subtask-form {
    display:flex;
    gap:10px;
    align-items:center;
}

.subtask-form input {
    flex:1;
    margin:0;
}

.subtask-form button {
    padding:10px 16px;
}

/* SUBTASK ITEM (EDITABLE) */
.subtask-item {
    display:flex;
    align-items:center;
    gap:10px;
    margin-top:8px;
}

.subtask-item input[type="text"] {
    flex:1;
    padding:6px;
    margin:0;
}

/* checkbox */
.subtask-item input[type="checkbox"] {
    width:auto;
}

/* small button */
.subtask-item button {
    padding:6px 10px;
    font-size:12px;
}

/* PROGRESS */
.progress-bar {
    width:100%;
    height:8px;
    background:#eee;
    border-radius:10px;
    overflow:hidden;
    margin-top:8px;
}

.progress-fill {
    height:100%;
    background:#f39c12;
}

/* ERROR */
.error {
    color:red;
    font-size:13px;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <a href="{{ route('tasks.index') }}" style="color:white;text-decoration:none;">⬅ Back</a>
    <h2>TaskTrack</h2>
</div>

<!-- MAIN -->
<div class="main">

<div class="banner">
    <h2>Edit Task</h2>
    <p>Update your task details</p>
</div>

<div class="form-card">

@if($errors->any())
    @foreach($errors->all() as $error)
        <p class="error">{{ $error }}</p>
    @endforeach
@endif

<!-- TASK FORM -->
<form method="POST" action="{{ route('tasks.update',$task->id) }}">
@csrf

<input type="text" name="title" value="{{ old('title',$task->title) }}" placeholder="Task Title">

<textarea name="description" placeholder="Description">{{ old('description',$task->description) }}</textarea>

<select name="category_id" required>
    <option value="">Select Category</option>
    @foreach($categories as $cat)
        <option value="{{ $cat->id }}"
            {{ $task->category_id == $cat->id ? 'selected' : '' }}>
            {{ $cat->name }}
        </option>
    @endforeach
</select>

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

<button type="submit" style="width:100%;">Update Task</button>
</form>

<!-- SUBTASK SECTION -->
<div class="subtask-box">

<h3>Subtasks</h3>

<!-- ADD -->
<form method="POST" action="{{ route('subtask.add',$task->id) }}" class="subtask-form">
@csrf
<input type="text" name="title" placeholder="New subtask...">
<button type="submit">Add</button>
</form>

<!-- LIST -->
@foreach($task->subtasks as $sub)

<form method="POST" action="{{ route('subtask.update',$sub->id) }}" class="subtask-item">
@csrf

<input type="checkbox"
    onclick="window.location='{{ route('subtask.toggle',$sub->id) }}'"
    {{ $sub->is_done ? 'checked' : '' }}>

<input type="text" name="title" value="{{ $sub->title }}">

<button type="submit">Save</button>

</form>

@endforeach

<!-- PROGRESS -->
@php
    $total = $task->subtasks->count();
    $done = $task->subtasks->where('is_done', true)->count();
    $percent = $total ? ($done/$total)*100 : 0;
@endphp

@if($total > 0)
<div style="margin-top:15px;">
    <small>{{ round($percent) }}% completed</small>

    <div class="progress-bar">
        <div class="progress-fill" style="width:{{ $percent }}%"></div>
    </div>
</div>
@endif

</div>

</div>
</div>

</body>
</html>