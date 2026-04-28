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

/* SIDEBAR */
.sidebar {
    width:230px;
    background:linear-gradient(135deg,#28a745,#5cbf88);
    color:white;
    height:100vh;
    padding:20px;
    position:fixed;
}

/* MAIN */
.main {
    flex:1;
    margin-left:270px;
    padding:20px;
}

/* CARD */
.form-card {
    background:white;
    padding:25px;
    border-radius:12px;
    width:100%;
    max-width:500px;
    margin:40px auto;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}

/* INPUTS */
input, textarea, select {
    width:95%;
    padding:10px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid #ddd;
    outline:none;
}

/* BUTTON */
button {
    background:linear-gradient(135deg,#28a745,#5cbf88);
    color:white;
    padding:10px;
    border:none;
    border-radius:8px;
    width:100%;
    cursor:pointer;
}

/* SUBTASK SECTION */
.subtask-box {
    margin-top:15px;
    padding-top:15px;
    border-top:1px solid #eee;
}

/* ADD SUBTASK ROW */
.subtask-form {
    display:flex;
    gap:10px;
    margin-bottom:10px;
}

.subtask-form input {
    flex:1;
    margin:0;
}

.subtask-form button {
    width:auto;
    padding:10px 14px;
}

/* SUBTASK ITEM */
.subtask-item {
    font-size:14px;
    padding:6px 0;
    color:#333;
}
</style>
</head>

<body>

<div class="sidebar">
    <a href="{{ route('tasks.index') }}" style="color:white;text-decoration:none;">⬅ Back</a>
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

<!-- SUBTASK SECTION -->
<div class="subtask-box">

    <h3>Subtasks</h3>

    <div class="subtask-form">
        <input type="text" name="subtask_input" placeholder="Add subtask...">
        <button type="button" onclick="addSubtask()">Add</button>
    </div>

    <div id="subtask-list"></div>

    <!-- hidden input container -->
    <div id="hidden-inputs"></div>

</div>

<button type="submit">Create Task</button>

</form>

</div>

</div>

<script>
let index = 0;

function addSubtask() {
    let input = document.querySelector('input[name="subtask_input"]');
    let value = input.value.trim();

    if (!value) return;

    // show in UI
    let list = document.getElementById('subtask-list');
    let div = document.createElement('div');
    div.className = 'subtask-item';
    div.innerText = "• " + value;
    list.appendChild(div);

    // create hidden input for backend
    let hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = 'subtasks[]';
    hidden.value = value;

    document.getElementById('hidden-inputs').appendChild(hidden);

    input.value = '';
}
</script>

</body>
</html>