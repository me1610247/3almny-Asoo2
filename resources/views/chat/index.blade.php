@extends('layout')

@section('content')
<div class="container my-5">
    @if (Auth::user()->role == 'user')
    <h2 class="mb-4">Chat with {{ $trainer->user->name }}</h2>  <!-- Display the user name -->
    @else
    <h2 class="mb-4">Chat with The Trainee</h2>  <!-- Display the user name -->
    @endif

    <div class="chat-box mb-4" style="height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 15px; border-radius: 8px; background-color: #f9f9f9;">
        <!-- Display all messages in the conversation -->
        @foreach($messages as $message)
            <div class="message @if($message->user_id === auth()->id()) message-sent @else message-received @endif mb-3">
                <div class=" shadow-sm">
                    <div class="">
                        <!-- Check if the message is from the logged-in user (trainer or user) and display the appropriate name -->
                        <p class="mb-1">
                            <strong>
                                {{ $message->user_id === auth()->id() ? 'You' : $message->user->name }}:
                            </strong>
                            {{ $message->content }}
                        </p>
                        <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Send message form -->
    <form action="{{ route('chat.send', ['trainerId' => $trainer->id, 'userId' => $user->id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <textarea name="content" class="form-control" rows="3" placeholder="Type your message..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Send</button>
    </form>
</div>

<!-- Add Custom Styles for Chat Messages -->
@section('styles')
    <style>
        /* Style for received messages */
        .message-received .card-body {
            background-color: #f1f1f1;
            text-align: left;
            border-left: 3px solid #28a745;
        }
        
        /* Style for sent messages */
        .message-sent .card-body {
            background-color: #007bff;
            color: #fff;
            text-align: right;
            border-right: 3px solid #0056b3;
        }

        /* Style for message timestamps */
        .message-sent small, .message-received small {
            font-size: 0.9rem;
            opacity: 0.7;
        }

        .message-sent small {
            color: rgba(255, 255, 255, 0.7);
        }

        .message-received small {
            color: rgba(0, 0, 0, 0.6);
        }

        /* Chat Box Style */
        .chat-box {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .chat-box .card {
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .form-group textarea {
            resize: none;
        }

        /* Button Styles */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        /* Additional message bubble styles */
        .message-sent .card-body, .message-received .card-body {
            border-radius: 10px;
            padding: 10px;
            margin: 5px 0;
        }

        /* Adjust spacing for different screen sizes */
        @media (max-width: 767px) {
            .message-sent .card-body, .message-received .card-body {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
@endsection

@endsection
