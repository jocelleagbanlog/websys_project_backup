<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create Task</title>
<style>
body {
    margin:0;
    font-family:'Segoe UI', Arial;
    display:flex;
    background:#f4f6f9;
}

.sidebar {
    width:230px;
    background:linear-gradient(135deg,#28a745,#5cbf88);
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

.form-card {
    background:white;
    padding:25px;
    border-radius:12px;
    width:100%;
    max-width:500px;
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
    background:linear-gradient(135deg,#28a745,#5cbf88);
    color:white;
    padding:10px;
    border:none;
    border-radius:8px;
    width:100%;
}
</style>
</head>

<body>

<div class="sidebar">
    <a href="{{ route('tasks.index') }}" style="color:white;">⬅ Back</a>
    <h2>TaskTrack</h2>
</div>

<div class="main">

<div class="form-card">

<h2>Create Task</h2>

<form method="POST" action="{{ route('tasks.store') }}">
@csrf

<input type="text" name="title" placeholder="Title">

<textarea name="description" placeholder="Description"></textarea>

<select name="category_id">
    <option value="">Select Category</option>
    @foreach($categories as $cat)
        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
    @endforeach
</select>

<select name="priority">
    <option value="">Priority</option>
    <option value="low">Low</option>
    <option value="medium">Medium</option>
    <option value="high">High</option>
</select>

<button type="submit">Create Task</button>

</form>

</div>

</div>

</body>
</html>
<!-- <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Task</title>

<style>
body { 
    margin:0; 
    font-family:'Segoe UI', Arial; 
    display:flex; 
    background:#f4f6f9;
}

.sidebar {
    width:230px;
    background:linear-gradient(135deg,#28a745,#5cbf88);
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
    background:linear-gradient(135deg,#28a745,#5cbf88);
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
    background:linear-gradient(135deg,#28a745,#5cbf88);
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
        <h2>Create New Task</h2>
        <p>Add your task details below</p>
    </div>

    <div class="form-card">

    @if($errors->any())
        @foreach($errors->all() as $error)
            <p style="color:red">{{ $error }}</p>
        @endforeach
    @endif

    <form method="POST" action="{{ route('tasks.store') }}">
    @csrf

    <input type="text" name="title" placeholder="Task Title" value="{{ old('title') }}">

    <textarea name="description" placeholder="Description">{{ old('description') }}</textarea>

    <select name="category_id" required>
        <option value="">Select Category</option>
        @foreach($categories as $cat)
        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
    </select>

    <select name="priority">
        <option value="">Select Priority</option>
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
    </select>

    <button type="submit">Create Task</button>

    </form>

    <a href="{{ route('tasks.index') }}" class="back">⬅ Back</a>

    </div>

    </div>

</body>
</html> -->