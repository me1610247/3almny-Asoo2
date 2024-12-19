@extends('layout')

@section('content')
<div class="d-flex">
    <div class="bg-dark text-white p-3 sidebar" style="width: 250px; height: 100vh;">
        <h4 class="text-center mb-4">Admin Panel</h4>
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white" href="{{ route('admin.pending-courses') }}">Pending Courses</a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white" href="{{ route('admin.pending-sessions') }}">Pending Sessions</a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white" href="{{ route('admin.users') }}">User Management</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">Other Management</a>
            </li>
        </ul>
    </div>
    <div class="flex-grow-1 p-4 ms-auto" style="margin-left: 250px;">
        <div class="container">
            <h2>Pending Courses</h2>
            @if($pendingSessions->isEmpty())
                <div class="alert alert-success" role="alert">
                    No pending sessions at the moment.
                </div>
            @else
                <div class="row">
                    @foreach($pendingSessions as $session)
                    <div class="col-md-4">
                        <div class="card shadow-sm border-light rounded mb-4" style="background-color: #f9f9f9; border-radius: 12px;">
                            <div class="card-body">
                                <h5 class="card-text">Course Title: {{ $session->course->title }}</h5>
                               <hr>
                                <h5 class="card-text">Trainer Name: {{ $session->trainer->name }}</h5>
                               <hr>
                                <h5 class="card-text">Course Price: {{ $session->course->price }} LE</h5>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <form action="{{ route('admin.sessions.accept', $session->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Approve</button>
                                    </form>
                                    
                                    <form action="{{ route('admin.sessions.reject', $session->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Reject</button>
                                    </form>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('admin.sessions.details', $session->id) }}" class="btn btn-primary btn-sm">View Session Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
