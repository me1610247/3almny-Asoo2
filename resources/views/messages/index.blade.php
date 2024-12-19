<!-- messages/index.blade.php -->
@extends('layout')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Conversations</h2>

    <div class="row">
        @foreach($conversations as $conversation)
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <!-- Determine who the sender and receiver are -->
                    <p><strong>From:</strong> {{ $conversation->trainer_id === auth()->id() ? 'You' : ucwords($conversation->user->name) }}</p>
                    
                    <!-- Display the latest message content -->
                    <p><strong>Latest Message:</strong> {{ $conversation->content }}</p>
                    <p class="text-muted">{{ $conversation->created_at->diffForHumans() }}</p>
    
                    <!-- Link to chat page for the specific conversation -->
                    <a href="{{ route('chat.index', ['trainerId' => $conversation->trainer_id, 'userId' => auth()->id()]) }}" class="btn btn-primary rounded-pill mt-3">
                        Chat Now
                    </a>
                </div>
            </div>
        </div>
    @endforeach
    
    </div>

</div>
@endsection
