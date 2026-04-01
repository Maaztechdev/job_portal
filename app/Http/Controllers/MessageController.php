<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $conversations = Conversation::with(['userOne', 'userTwo', 'messages'])
            ->where(function ($q) use ($user) {
                $q->where('user_one_id', $user->id)
                  ->orWhere('user_two_id', $user->id);
            })
            ->latest('updated_at')
            ->get();
        return view('messages.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        if (!$conversation->userOne->is(Auth::user()) && !$conversation->userTwo->is(Auth::user())) {
            abort(403);
        }
        $conversation->load(['userOne', 'userTwo', 'messages.sender']);
        return view('messages.show', compact('conversation'));
    }

    public function startConversation(User $receiver)
    {
        $sender = Auth::user();

        if ($sender->id === $receiver->id) {
            return back()->with('error', 'You cannot start a conversation with yourself.');
        }

        $conversation = Conversation::where(function ($query) use ($sender, $receiver) {
            $query->where('user_one_id', $sender->id)
                  ->where('user_two_id', $receiver->id);
        })->orWhere(function ($query) use ($sender, $receiver) {
            $query->where('user_one_id', $receiver->id)
                  ->where('user_two_id', $sender->id);
        })->first();

        if ($conversation) {
            return redirect()->route('messages.show', $conversation);
        }

        $conversation = Conversation::create([
            'user_one_id' => $sender->id,
            'user_two_id' => $receiver->id,
        ]);

        return redirect()->route('messages.show', $conversation);
    }

    public function sendMessage(Request $request, Conversation $conversation)
    {
        if (!$conversation->userOne->is(Auth::user()) && !$conversation->userTwo->is(Auth::user())) {
            abort(403);
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        return back();
    }
}
