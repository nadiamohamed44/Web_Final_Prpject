<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>

<h2>Register</h2>

<form action="{{ route('register') }}" method="POST">
    @csrf

    <label>First Name</label>
    <input type="text" name="first_name" required><br>

    <label>Last Name</label>
    <input type="text" name="last_name" required><br>

    <label>Email</label>
    <input type="email" name="email" required><br>

    <label>Password</label>
    <input type="password" name="password" required><br>

    <label>Confirm Password</label>
    <input type="password" name="password_confirmation" required><br>

    <button type="submit">Register</button>
</form>

</body>
</html>
