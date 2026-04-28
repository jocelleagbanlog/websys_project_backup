<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<style>
body {
    margin:0;
    font-family:'Segoe UI';
    background:#f4f6f9;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.container {
    width:850px;
    height:450px;
    display:flex;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

.left {
    width:50%;
    background:linear-gradient(135deg,#3c8dbc,#5aa9c9);
    color:white;
    padding:40px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.left h1 {
    margin:0;
    font-size:32px;
}

.left p {
    margin-top:10px;
    opacity:0.9;
}

.right {
    width:50%;
    background:white;
    padding:40px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

h2 {
    margin-bottom:20px;
}

input {
    width:93%;
    padding:12px;
    margin:8px 0;
    border-radius:8px;
    border:1px solid #ddd;
}

button {
    width:100%;
    padding:12px;
    margin-top:10px;
    background:linear-gradient(135deg,#3c8dbc,#5aa9c9);
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
}

a {
    display:block;
    text-align:center;
    margin-top:10px;
    color:#3c8dbc;
}

.error { color:#dc3545; font-size:14px; }
.success { color:#28a745; font-size:14px; }

</style>
</head>

<body>

<div class="container">

    <div class="left">
        <h1>TaskTrack</h1>
        <h2>Welcome!</h2>
        <p>You can sign in to access your tasks and manage your workflow.</p>
    </div>

    <div class="right">

        @if(session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        <h2>Login</h2>

        <form method="POST" action="{{ route('login.check') }}">
        @csrf

            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror

            <input type="password" name="password" placeholder="Password">
            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror

            @if(session('error'))
                <p class="error">{{ session('error') }}</p>
            @endif

            <button type="submit">Login</button>
        </form>

        <a href="{{ route('register') }}">Create Account</a>

    </div>

</div>

</body>
</html>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<style>
body { margin:0; font-family:'Segoe UI'; display:flex; background:#f4f6f9; }

.sidebar {
    width:230px;
    background:#3c8dbc;
    color:white;
    height:100vh;
    padding:20px;
    position:fixed;
}

.main {
    margin-left:270px;
    padding:40px;
    margin-top:12%;
    width:100%;
}

.form-box {
    background:white;
    padding:30px;
    border-radius:15px;
    width:350px;
    margin:auto;
    box-shadow:0 4px 10px rgba(0,0,0,0.08);
}

h2 { text-align:center; }

input {
    width:93%;
    padding:12px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid #ddd;
}

button {
    width:100%;
    padding:12px;
    background:linear-gradient(135deg,#3c8dbc,#5aa9c9);
    color:white;
    border:none;
    border-radius:8px;
}

.error { color:#dc3545; }
.success { color:#28a745; }

a { display:block; text-align:center; margin-top:10px; }
</style>
</head>

<body>

    <div class="sidebar">
        <h2>TaskTrack</h2>
    </div>

    <div class="main">
    <div class="form-box">

    <h2>Login</h2>

    <form method="POST" action="{{ route('login.check') }}">
    @csrf

        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
        @error('email')
            <p class="error">{{ $message }}</p>
        @enderror

        <input type="password" name="password" placeholder="Password">
        @error('password')
            <p class="error">{{ $message }}</p>
        @enderror

        @if(session('error'))
            <p class="error">{{ session('error') }}</p>
        @endif

        @if(session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

    <button type="submit">Login</button>
</form>

    <a href="{{ route('register') }}">Create Account</a> 

    
    </div>
    </div>

</body>
</html> -->



