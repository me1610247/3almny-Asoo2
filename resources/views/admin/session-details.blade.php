@extends('layout')

@section('content')
<div class="d-flex">
    <!-- Sidebar -->
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

    <!-- Main Content -->
    <div class="container mt-4">
        <h2 class="text-dark mb-4">Session Details</h2>

        <!-- Trainer Information -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light text-dark">
                <h5>Trainer Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $session->trainer->user->name }}</p>
                <p><strong>Email:</strong> {{ $session->trainer->user->email }}</p>
                <p><strong>National ID:</strong> {{ $session->trainer->national_id }}</p>
                <p><strong>License ID:</strong> {{ $session->trainer->license_id }}</p>
                <p><strong>License End Date:</strong> {{ $session->trainer->license_end_date }}</p>
                <p><strong>Phone:</strong> {{ $session->trainer->phone }}</p>
                <p><strong>Date of Birth:</strong> {{ $session->trainer->date_of_birth }}</p>
                <p><strong>City:</strong> {{ $session->trainer->city }}</p>
                <p><strong>Address:</strong> {{ $session->trainer->address }}</p>
                <p><strong>Has Car:</strong> {{ $session->trainer->has_car ? 'Yes' : 'No' }}</p>

                <!-- Trainer Images -->
                <div class="row mt-3">
                    @if($session->trainer->license_front_image)
                        <div class="col-md-3">
                            <p><strong>License Front Image:</strong></p>
                            <img src="{{ route('trainer.image', ['filename' => basename($session->trainer->license_front_image)]) }}" class="img-thumbnail fixed-size">
                        </div>
                    @endif

                    @if($session->trainer->license_back_image)
                        <div class="col-md-3">
                            <p><strong>License Back Image:</strong></p>
                            <img src="{{ route('trainer.image', ['filename' => basename($session->trainer->national_id_front_image)]) }}" class="img-thumbnail fixed-size">
                        </div>
                    @endif

                    @if($session->trainer->national_id_front_image)
                        <div class="col-md-3">
                            <p><strong>National ID Front:</strong></p>
                            <img src="{{ route('trainer.image', ['filename' => basename($session->trainer->national_id_front_image)]) }}" class="img-thumbnail fixed-size">
                        </div>
                    @endif

                    @if($session->trainer->national_id_back_image)
                        <div class="col-md-3">
                            <p><strong>National ID Back:</strong></p>
                            <img src="{{ route('trainer.image', ['filename' => basename($session->trainer->national_id_back_image)]) }}" class="img-thumbnail fixed-size">
                        </div>
                    @endif

                    @if($session->trainer->has_car && $session->trainer->car_license_image)
                        <div class="col-md-3 mt-3">
                            <p><strong>Car License Image:</strong></p>
                            <img src="{{ route('trainer.image', ['filename' => basename($session->trainer->car_license_image)]) }}" class="img-thumbnail fixed-size">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Course Information -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light text-dark">
                <h5>Course Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Title:</strong> {{ $session->course->title }}</p>
                <p><strong>Description:</strong> {{ $session->course->description }}</p>
                <p><strong>Price:</strong> {{ $session->course->price }} LE</p>
            </div>
        </div>

        <!-- Session Information -->
        <div class="card shadow-sm">
            <div class="card-header bg-light text-dark">
                <h5>Session Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Status:</strong> {{ ucfirst($session->status) }}</p>
                <p><strong>Number of Sessions:</strong> {{ $session->number_of_sessions }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
    .fixed-size {
        width: 200px; /* Set desired width */
        height: 200px; /* Set desired height */
        object-fit: cover;
    }
</style>
@endsection
