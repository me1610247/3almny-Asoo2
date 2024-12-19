@extends('layout')

<title>3almny Asoo2 - Trainer Sessions</title>

@section('content')

<div class="flex-grow-1 p-4 ms-auto" style="margin-left: 250px;">
    <div class="container">
        <h2 class="text-center mb-4">Sessions</h2>
        <div class=" mt-3 mb-3">
            <a href="{{ route('session.create') }}" class="btn btn-primary btn-lg">Add New Session</a>
        </div>
        @if($sessions->isEmpty())
            <div class="alert alert-info text-center" role="alert">
                No sessions at the moment
            </div>
        @else
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
            <div class="row">
                @foreach($sessions as $session)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-light rounded" style="background-color: #ffffff; border-radius: 12px; transition: transform 0.2s;">
                        <div class="card-body">
                            <h5 class="card-title line text-primary">{{ $session->course->title }}</h5>
                            <hr>
                            <p class="card-text"><strong>Trainer Name:</strong> {{ ucwords($session->trainer->user->name) }}</p>
                            <p class="card-text"><strong>Course Price:</strong> {{ $session->course->price }} LE</p>
                            <hr>
                            <p class="card-text">
                                <strong>Session Status:</strong> 
                                <span class="{{ $session->status === 'accepted' ? 'text-success' : 'text-warning' }}">
                                    {{ ucwords($session->status) }}
                                </span>
                            </p>
                            <p class="card-text"><small>Created at: {{ $session->created_at->format('d M Y, h:i A') }}</small></p>

                            @if($session->status == 'accepted' && $session->trainer_id == auth()->id()) 
                            <!-- Only show the button if the session is accepted and the logged-in user is the trainer -->
                            <form action="{{ route('session.end', $session->id) }}" method="POST">
                                @csrf
                                @method('PATCH') <!-- Use PATCH for updating existing resources -->
                                <button type="submit" class="btn btn-danger btn-sm mt-2">Close Session</button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<style>
    .card {
        cursor: pointer;
        transition: transform 0.2s;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    h2 {
        color: #333;
    }

    .alert {
        border-radius: 8px;
    }
    .line{
        height: 40px;
    }
</style>
@endsection
