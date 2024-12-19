@extends('layout')

@section('content')
<style>
    .line{
        height: 50px;
    }
</style>
<div class="container my-5">
    <h2 class="mb-4">Session Applications</h2>
    <div class="row">
        @foreach($applications as $application)
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title line">{{ $application->session->course->title }}</h5>
                    <p><strong>User:</strong> {{ ucwords($application->user->name) }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($application->status) }}</p>

                    <div class="d-flex justify-content-between">
                        @if($application->status === 'pending')
                            <form action="{{ route('application.approve', $application->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                            
                            <form action="{{ route('application.reject', $application->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                        @elseif($application->status === 'accepted')
                            <!-- Redirect to chat with the user when the button is clicked -->
                            <a href="{{ route('chat.index', ['trainerId' => Auth::user()->id, 'userId' => $application->user->id]) }}" class="btn btn-primary">Contact User</a>

                            <!-- End Session Button to mark the session as completed -->
                            <form action="{{ route('session.end', $application->session->id) }}" method="POST" class="mt-2">
                                @csrf
                                @method('PATCH') <!-- This ensures the form uses the PATCH method for the session end route -->
                                <button type="submit" class="btn btn-danger">End Session</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
