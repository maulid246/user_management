<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function index() {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete($user->photo);
            }
            $path = $request->file('photo')->store('photos');
            $user->photo = $path;
        }

        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        if ($user->photo) {
            Storage::delete($user->photo);
        }
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
