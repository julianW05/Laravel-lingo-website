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
            return redirect()->route('friends.index')->with('error', 'Gebruiker met opgegeven e-mailadres bestaat niet.');
        }

        $user = auth()->user();

        if ($user->friends->contains($friend)) {
            return redirect()->route('friends.index')->with('error', 'Gebruiker is al toegevoegd als vriend.');
        }

        if ($friend->id === $user->id) {
            return redirect()->route('friends.index')->with('error', 'Je kunt jezelf niet toevoegen als vriend.');
        }

        $user->friends()->attach($friend);

        return redirect()->route('friends.index')->with('success', 'Vriend toegevoegd.');
    }

    public function remove(User $friend)
    {
        auth()->user()->friends()->detach($friend);
        return redirect()->route('friends.index')->with('success', 'Vriend verwijderd.');
    }
}
