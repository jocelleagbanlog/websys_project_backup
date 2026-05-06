<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Category</title>

<style>
body { 
    margin:0; 
    font-family:'Segoe UI', Arial; 
    display:flex; 
    background:#f4f6f9;
}

.sidebar {
    width:230px;
    background:linear-gradient(135deg,#dc3545,#e57373);
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
    background:linear-gradient(135deg,#dc3545,#e57373);
    color:white;
    padding:20px;
    border-radius:15px;
    margin-bottom:20px;
}

/* card */
.form-card {
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 3px 10px rgba(0,0,0,0.05);
    width:400px;
    max-width:500px;
    width:100%;
    margin:40px auto;
}

input {
    width:95%;
    padding:12px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid #ddd;
}

button {
    width:100%;
    padding:12px;
    background:linear-gradient(135deg,#dc3545,#e57373);
    color:white;
    border:none;
    border-radius:8px;
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
        <h2>Add Category</h2>
        <p>Create a new category for your tasks</p>
    </div>

    <!-- form -->
    <div class="form-card">
        <form method="POST" action="{{ route('categories.store') }}">
            @csrf

            <input type="text" name="name" placeholder="Category name">

            <button type="submit">Save Category</button>
        </form>
    </div>
</div>

</body>
</html>