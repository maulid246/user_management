<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $user->name }}" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="{{ $user->email }}" required><br>
        <label for="photo">Photo:</label>
        <input type="file" name="photo"><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
