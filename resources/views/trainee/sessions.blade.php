@extends('layout')
<title>3almny Asoo2 - User Sessions</title>
@section('content')
<div class="container my-5">
    <h2 class="mb-4">Available Sessions</h2>

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('sessions.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <select name="gender" class="form-control">
                    <option value="">Filter by Gender</option>
                    <option value="male" {{ request()->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ request()->gender == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary rounded-pill px-4">Apply Filter</button>
            </div>
        </div>
    </form>

    <!-- Check if there are no sessions available based on the filter -->
    @if($sessions->isEmpty())
        <p class="alert alert-primary">No sessions available with the selected filter.</p>
    @else
        <div class="row">
            @foreach($sessions as $session)
            <div class="col-md-4">
                <div class="card shadow-sm mb-4" style="border-radius: 12px;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $session->course->title }}</h5>
                        <p class="card-text"><strong>Trainer:</strong> {{ $session->trainer->user->name }}</p>

                        <!-- Displaying trainer reviews (average rating) -->
                        <p class="card-text"><strong>Reviews:</strong> 
                            @if($session->trainer->reviews && count($session->trainer->reviews) > 0)
                                {{ round(array_sum(array_column($session->trainer->reviews, 'rating')) / count($session->trainer->reviews), 1) }} / 5
                            @else
                                No reviews yet.
                            @endif
                        </p>

                        <p class="card-text"><strong>Price:</strong> {{ $session->course->price }} LE</p>
                        <p class="card-text"><strong>Gender:</strong> {{ ucwords($session->trainer->gender) }}</p>

                        <div class="text-center">
                            @if(in_array($session->id, $appliedSessions))
                                @if($session->status == 'completed')
                                    @if(!$session->has_reviewed)
                                        <!-- Show Add Review button if no review has been submitted -->
                                        <a href="{{ route('review.create', $session->id) }}" class="btn btn-success rounded-pill px-4">Add Review</a>
                                    @else
                                        <!-- Show a message if the review is already submitted -->
                                        <p class="text-muted">Review submitted. Thank you!</p>
                                    @endif
                                @elseif($session->status == 'pending')
                                    <p class="text-muted">Session is Pending!</p>
                                @else
                                    <p class="text-muted">Session is Active Now</p>
                                @endif
                            @else
                                <form action="{{ route('session.apply', $session->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary rounded-pill px-4 mx-4">Apply</button>
                                </form>
                            @endif
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('course.details', $session->course->id) }}" class="btn btn-secondary rounded-pill px-4 mx-4">Details</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
