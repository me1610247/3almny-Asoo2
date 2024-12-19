@extends('layout')

@section('content')
<div class="container">
    <div class="card shadow-sm mb-4 mb-3 mt-3">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Trainer Details</h2>

            <!-- Display Trainer Image -->
            <div class="text-center mb-4">
                @if($trainer->user->profile_image)
                    <img src="{{ asset('storage/'.$trainer->user->profile_image) }}" alt="Trainer Image" class="img-fluid rounded-circle" style="max-width: 200px;">
                @else
                    <img src="{{ asset('images/default-avatar.png') }}" alt="Default Image" class="img-fluid rounded-circle" style="max-width: 200px;">
                @endif
            </div>

            <!-- Trainer Basic Information -->
            <div class="mb-3">
                <h5 class="card-text"><strong>Name:</strong> {{ $trainer->user->name }}</h5>
                <p class="card-text"><strong>Email:</strong> {{ $trainer->user->email }}</p>
                <p class="card-text"><strong>Phone:</strong> {{ $trainer->phone }}</p>
                <p class="card-text"><strong>Location:</strong> {{ $trainer->city }}</p>
                <p class="card-text"><strong>Address:</strong> {{ $trainer->address }}</p>
                <p class="card-text"><strong>Gender:</strong> {{ $trainer->gender }}</p>
                <p class="card-text"><strong>Date of Birth:</strong> {{ $trainer->date_of_birth }}</p>
                <p class="card-text"><strong>Has Car:</strong> {{ $trainer->has_car ? 'Yes' : 'No' }}</p>
            </div>

            <!-- National ID and License Information Section -->
            <h3 class="mt-4 text-primary">License and National ID Information</h3>
            <div class="row">

                <!-- National ID -->
                <div class="col-md-6 mb-3">
                    <p><strong>National ID:</strong> {{ $trainer->national_id ?? 'Not provided.' }}</p>
                </div>

                <!-- License ID -->
                <div class="col-md-6 mb-3">
                    <p><strong>License ID:</strong> {{ $trainer->license_id ?? 'Not provided.' }}</p>
                </div>

                <!-- License End Date -->
                <div class="col-md-6 mb-3">
                    <p><strong>License End Date:</strong> {{ $trainer->license_end_date ? \Carbon\Carbon::parse($trainer->license_end_date)->format('d M, Y') : 'Not provided.' }}</p>
                </div>
                <div class="row">
                <!-- License Front Image -->
                <div class="col-md-4 mb-3">
                    @if($trainer->license_front_image)
                        <p><strong>License Front Image:</strong></p>
                        <img src="{{ route('trainer.image', ['filename' => basename($trainer->license_front_image)]) }}" class="img-fluid rounded mb-3" style="max-height: 200px; object-fit: cover;">
                    @else
                        <p><strong>License Front Image:</strong> Not provided.</p>
                    @endif
                </div>

                <!-- License Back Image -->
                <div class="col-md-4 mb-3">
                    @if($trainer->license_back_image)
                        <p><strong>License Back Image:</strong></p>
                        <img src="{{ route('trainer.image', ['filename' => basename($trainer->license_back_image)]) }}" class="img-fluid rounded mb-3" style="max-height: 200px; object-fit: cover;">
                    @else
                        <p><strong>License Back Image:</strong> Not provided.</p>
                    @endif
                </div>

                <!-- National ID Front Image -->
                <div class="col-md-4 mb-3">
                    @if($trainer->national_id_front_image)
                        <p><strong>National ID Front Image:</strong></p>
                        <img src="{{ route('trainer.image', ['filename' => basename($trainer->national_id_front_image)]) }}" class="img-fluid rounded mb-3" style="max-height: 200px; object-fit: cover;">
                    @else
                        <p><strong>National ID Front Image:</strong> Not provided.</p>
                    @endif
                </div>

                <!-- National ID Back Image -->
                <div class="col-md-4 mb-3">
                    @if($trainer->national_id_back_image)
                        <p><strong>National ID Back Image:</strong></p>
                        <img src="{{ route('trainer.image', ['filename' => basename($trainer->national_id_back_image)]) }}" class="img-fluid rounded mb-3" style="max-height: 200px; object-fit: cover;">
                    @else
                        <p><strong>National ID Back Image:</strong> Not provided.</p>
                    @endif
                </div>

                <!-- Car License Image (Only if trainer has a car) -->
                @if($trainer->has_car && $trainer->car_license_image)
                    <div class="col-md-4 mb-3">
                        <p><strong>Car License Image:</strong></p>
                        <img src="{{ asset('storage/'.$trainer->car_license_image) }}" alt="Car License Image" class="img-fluid rounded mb-3" style="max-height: 200px; object-fit: cover;">
                    </div>
                @elseif($trainer->has_car)
                    <div class="col-md-4 mb-3">
                        <p><strong>Car License Image:</strong> Not provided.</p>
                    </div>
                @endif

            </div>
            </div>
            <!-- Back to Pending Courses Button -->
            <div class="mt-4">
                <a href="{{ route('admin.pending-courses') }}" class="btn btn-primary">Back to Pending Courses</a>
            </div>
        </div>
    </div>
</div>
@endsection
