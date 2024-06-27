<?php

namespace App\Http\Controllers;

use App\Models\TransactionModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    // Display a listing of the resource.
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::query()
            ->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->paginate(10);

        return view('users.admin.index', compact('users'));
    }

    // Show the form for creating a new resource.
    public function create(Request $request)
    {
        
        return view('users.admin.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'image' => 'nullable|image|max:2048'
        ]);

        $user = new User($request->all());
        $user->password = bcrypt($request->password);
        if ($request->hasFile('image')) {
            $user->image = $request->file('image')->store('images', 'public');
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.admin.edit', compact('user'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|image|max:2048'
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $user->image = $request->file('image')->store('images', 'public');
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $userTransaction = TransactionModel::all()->where('id_user', $id);
        if ($userTransaction->count() > 0) {
            return response()->json(array('success' => $userTransaction));
    return redirect()->route('users.index')->with('warning', "User `{$userTransaction->first()->user->name}` tidak bisa dihapus karena masih memiliki transaksi");
}

        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
