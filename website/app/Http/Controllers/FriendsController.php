<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FriendsController extends Controller
{
    public function index()
    {
        $friends = auth()->user()->friends;
        return view('friends.index', compact('friends'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
        ]);

        $friend = User::where('email', $validatedData['email'])->first();

        if (!$friend) {
            return redirect()->route('friends.index')->with('error', 'User with the provided email does not exist.');
        }

        $user = auth()->user();

        if ($user->friends->contains($friend)) {
            return redirect()->route('friends.index')->with('error', 'User is already added as a friend.');
        }

        if ($friend->id === $user->id) {
            return redirect()->route('friends.index')->with('error', 'You cannot add yourself as a friend.');
        }

        $user->friends()->attach($friend);

        return redirect()->route('friends.index')->with('success', 'Friend added successfully.');
    }

    public function remove(User $friend)
    {
        auth()->user()->friends()->detach($friend);
        return redirect()->route('friends.index')->with('success', 'Friend removed successfully.');
    }
}
