<!-- filepath: c:\xampp\htdocs\Adminischool\resources\views\emails\teacher-created.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Created</title>
</head>
<body>
    <h1>Welcome, {{ $teacher->first_name }} {{ $teacher->last_name }}</h1>
    <p>Your account has been created successfully. Here are your login details:</p>
    <p>Email: {{ $teacher->email }}</p>
    <p>Password: {{ $password }}</p>
    <p>Please <a href="{{ route('login') }}">click here</a> to login.</p>
</body>
</html>