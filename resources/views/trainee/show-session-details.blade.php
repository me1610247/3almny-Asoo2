@extends('layout')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">{{ $course->title }}</h2>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Course Description</h5>
            <p class="card-text">{{ $course->description }}</p>
            <h5 class="card-title">Price</h5>
            <p class="card-text">{{ $course->price }} LE</p>
        </div>
    </div>
    
    <h3 class="mb-4">Trainer Information</h3>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Trainer</h5>
            <p class="card-text">{{ $course->trainer->user->name }}</p>
            <h5 class="card-title">Location</h5>
            <p class="card-text">{{ $course->trainer->city }}</p>
            <h5 class="card-title">Address</h5>
            <p class="card-text">{{ $course->trainer->address }}</p>
            <h5 class="card-title">Phone</h5>
            <p class="card-text">{{ $course->trainer->phone }}</p>
            <h5 class="card-title">Reviews</h5>
            <p class="card-text">{{ $course->reviews }}</p>
        </div>
    </div>

    <h3 class="mb-4">Session Details</h3>
    <div class="row">
        @foreach($course->sessions as $session)
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">{{ $session->title }}</h5>
                    <p class="card-text"><strong>Number of Sessions:</strong> {{ $session->number_of_sessions }}</p>
                    <p class="card-text"><strong>Added in:</strong> {{ $session->created_at->format('d M Y, h:i A') }}</p>
                    
                    @if(in_array($session->id, $appliedSessions))
                    @if($session->status == 'accepted')
                    <p class="text-muted">Session is Active Now</p>
                @else
                    <p class="text-muted">Waiting for captain to respond</p>
                @endif
                    @else
                        <form action="{{ route('session.apply', $session->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Apply</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <a href="{{ route('account.home') }}" class="btn btn-secondary rounded-pill">Back to Home</a>
</div>
@endsection
