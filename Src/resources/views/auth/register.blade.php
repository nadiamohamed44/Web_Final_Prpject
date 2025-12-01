<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>Register</h2>

@if ($errors->any())
    <div style="color:red;">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<form method="POST" action="/register">
    @csrf

    <label>First Name</label><br>
    <input type="text" name="first_name" value="{{ old('first_name') }}"><br><br>

    <label>Last Name</label><br>
    <input type="text" name="last_name" value="{{ old('last_name') }}"><br><br>

    <label>Email</label><br>
    <input type="email" name="email" value="{{ old('email') }}"><br><br>

    <label>Password</label><br>
    <input type="password" name="password"><br><br>

    <label>Confirm Password</label><br>
    <input type="password" name="password_confirmation"><br><br>

    <button type="submit">Register</button>
</form>

<br>
<a href="/login">Already have an account? Login</a>

</body>
</html>
