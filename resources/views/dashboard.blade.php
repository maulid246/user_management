<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            width: 100%;
        }
        h1 {
            margin-top: 0;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .logout-link {
            margin-top: 20px;
            text-align: center;
        }
        .logout-link form {
            display: inline;
        }
        .logout-link button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .logout-link button:hover {
            background-color: #0056b3;
        }
        /* Popup styles */
        .popup {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .popup-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .popup-content input {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .popup-content button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .popup-content button:hover {
            background-color: #0056b3;
        }
        .popup-content .close {
            background-color: #ccc;
            color: #000;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }
        .popup-content .close:hover {
            background-color: #999;
        }
        .edit-btn, .delete-btn, .add-btn {
            cursor: pointer;
            color: #007bff;
            font-size: 18px;
            border: none;
            background: none;
        }
        .edit-btn:hover, .delete-btn:hover, .add-btn:hover {
            text-decoration: underline;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            color: #00570E;
            background-color: #8AF1AD;
            border-color: #8AF1AD;
        }
    </style>
    <script>
        function openPopup(userId) {
            document.getElementById('popup-' + userId).style.display = 'flex';
        }
        function openAddPopup() {
            document.getElementById('add-popup').style.display = 'flex';
        }
        function closePopup(userId) {
            document.getElementById('popup-' + userId).style.display = 'none';
        }
        function closeAddPopup() {
            document.getElementById('add-popup').style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>All Users</h1>
        
        @if(session('status'))
            <div class="alert">
                {{ session('status') }}
            </div>
        @endif
        
        <button class="add-btn" onclick="openAddPopup()">➕ Add User</button>
        
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registered On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('F j, Y') }}</td>
                        <td>
                            <button class="edit-btn" onclick="openPopup({{ $user->id }})">✏️</button>
                            <form method="POST" action="{{ route('deleteUser', $user->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">🗑️</button>
                            </form>
                        </td>
                    </tr>
                    <!-- Popup for editing user -->
                    <div id="popup-{{ $user->id }}" class="popup">
                        <div class="popup-content">
                            <button class="close" onclick="closePopup({{ $user->id }})">&times;</button>
                            <h2>Edit User</h2>
                            <form method="POST" action="{{ route('updateUser', $user->id) }}">
                                @csrf
                                @method('PUT')
                                <label for="name">Name:</label>
                                <input type="text" name="name" value="{{ $user->name }}" required>
                                <label for="email">Email:</label>
                                <input type="email" name="email" value="{{ $user->email }}" required>
                                <button type="submit">Save Changes</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
        
        <!-- Popup for adding user -->
        <div id="add-popup" class="popup">
            <div class="popup-content">
                <button class="close" onclick="closeAddPopup()">&times;</button>
                <h2>Add User</h2>
                <form method="POST" action="{{ route('storeUser') }}">
                    @csrf
                    <label for="name">Name:</label>
                    <input type="text" name="name" required>
                    <label for="email">Email:</label>
                    <input type="email" name="email" required>
                    <label for="password">Password:</label>
                    <input type="password" name="password" required>
                    <label for="password_confirmation">Confirm Password:</label>
                    <input type="password" name="password_confirmation" required>
                    <button type="submit">Add User</button>
                </form>
            </div>
        </div>

        <div class="logout-link">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>
