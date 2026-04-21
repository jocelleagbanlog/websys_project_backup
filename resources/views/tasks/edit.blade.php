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
    /* display:flex;
    justify-content:center;
    align-items:center;       
    height:100vh; */
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
    box-shadow:0 3px 10px rgba(0,0,0,0.05);
    width:500px;
    max-width:500px;
    width:100%;
    margin:40px auto;
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

.back {
    display:inline-block;
    margin-top:10px;
    text-decoration:none;
    color:white;
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
    <!-- 
    <a href="{{ route('tasks.index') }}" class="back">⬅ Back</a> -->

    </div>

    </div>

</body>
</html>