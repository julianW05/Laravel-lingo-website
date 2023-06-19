<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $messages = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->orderBy('created_at')
            ->get();

        return view('chats.chats', compact('messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_email' => 'required|email|exists:users,email',
            'message' => 'required',
        ], [
            'receiver_email.required' => 'Het veld voor het e-mailadres van de ontvanger is verplicht.',
            'receiver_email.email' => 'Voer een geldig e-mailadres van de ontvanger in.',
            'receiver_email.exists' => 'Het opgegeven e-mailadres van de ontvanger bestaat niet.',
            'message.required' => 'Het veld voor het bericht is verplicht.',
        ]);

        $receiver = User::where('email', $request->input('receiver_email'))->first();

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiver->id,
            'message' => $request->input('message'),
        ]);

        return redirect()->back()->with('success', 'Bericht verzonden.');
    }

    public function clearChats()
{
    $user = Auth::user();

    Message::where(function ($query) use ($user) {
        $query->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
    })->whereIn('id', function ($query) use ($user) {
        $query->select('id')
            ->from('messages')
            ->where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->orderBy('created_at');
    })->delete();

    return redirect()->back()->with('success', 'Chats zijn succesvol verwijderd.');
}


}
