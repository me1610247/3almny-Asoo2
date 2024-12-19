<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Trainer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Fetch all unique conversations with the latest message for the logged-in user
        $conversations = Message::with(['user', 'trainer'])  // Eager load user and trainer relationships
            ->where('user_id', $userId)
            ->orWhere('trainer_id', $userId)
            ->get()
            ->groupBy(function ($message) use ($userId) {
                // Group messages by user-trainer conversation pair
                return $message->user_id === $userId ? $message->trainer_id : $message->user_id;
            });

        // Loop through the conversations and retrieve the latest message for each
        foreach ($conversations as $trainerId => $messages) {
            $latestMessage = $messages->sortByDesc('created_at')->first(); // Get the latest message
            $conversations[$trainerId] = $latestMessage;
        }

        return view('messages.index', compact('conversations'));
    }
    public function fetchMessages($trainerId, $userId)
    {
        // Fetch the messages between the logged-in user and the trainer
        $messages = Message::with('user') // Load the sender's information
            ->where(function ($query) use ($trainerId, $userId) {
                $query->where('user_id', $userId)->where('trainer_id', $trainerId)
                      ->orWhere('user_id', $trainerId)->where('trainer_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();
    
        // Fetch the trainer and user models (optional, if you want to display more info)
        $trainer = Trainer::find($trainerId);
        $user = User::find($userId);
    
        return view('chat.index', compact('messages', 'trainer', 'user'));
    }
    

    public function sendMessage(Request $request, $trainerId, $userId)
    {
        $message = new Message();
        $message->user_id = $userId;
        $message->trainer_id = $trainerId;
        $message->content = $request->input('content');
        $message->save();

        return redirect()->route('chat.index', ['trainerId' => $trainerId, 'userId' => $userId]);
    }
}
