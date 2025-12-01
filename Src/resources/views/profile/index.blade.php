<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
</head>
<body>

<h2>Your Profile</h2>

@if (session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

<form method="POST" action="/profile">
    @csrf

    <label>First Name</label><br>
    <input type="text" name="first_name" value="{{ $user->first_name }}"><br><br>

    <label>Last Name</label><br>
    <input type="text" name="last_name" value="{{ $user->last_name }}"><br><br>

    <label>Phone</label><br>
    <input type="text" name="phone" value="{{ $user->phone }}"><br><br>

    <label>Address</label><br>
    <input type="text" name="address" value="{{ $user->address }}"><br><br>

    <button type="submit">Update Profile</button>
</form>

<br>
<a href="/logout">Logout</a>
<a href="/menu" class="btn btn-primary">Go to Menu</a>

</body>
</html>
