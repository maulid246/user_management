<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        // Check if the email exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email not registered.',
            ]);
        }

        // Check if the credentials are correct
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ]);
    }

    public function showRegisterForm() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.unique' => 'The username is already taken.',
            'email.unique' => 'The email is already registered.',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        Auth::login($user);

        return redirect()->route('login')->with('status', 'Registration successful. Please log in.');
    }

    public function dashboard() {
        $users = User::all();
        return view('dashboard', compact('users'));
    }

    public function createUser() {
        return view('auth.create');
    }
    
    public function storeUser(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.unique' => 'The username is already taken.',
            'email.unique' => 'The email is already registered.',
        ]);
    
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);
    
        return redirect()->route('dashboard')->with('status', 'User added successfully.');
    }

    public function updateUser(Request $request, $id) {
        $user = User::findOrFail($id);
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ], [
            'name.unique' => 'The username is already taken.',
            'email.unique' => 'The email is already registered.',
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->save();

        return redirect()->route('dashboard')->with('status', 'User updated successfully.');
    }

    public function deleteUser($id) {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('dashboard')->with('status', 'User deleted successfully.');
    }

    public function logout() {
        Auth::logout();
        return redirect('/login')->with('status', 'Logged out successfully.');
    }
}
