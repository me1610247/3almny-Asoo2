@extends('layout')

@section('content')
<div class="container my-5">
    <h2>Write a Review for Session: {{ $session->course->title }}</h2>

    <form action="{{ route('review.store', $session->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="review" class="form-label">Review</label>
            <textarea name="review" class="form-control" rows="4" required></textarea>
        </div>
        
        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1-5)</label>
            <input type="number" name="rating" class="form-control" min="1" max="5" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>
</div>
@endsection
