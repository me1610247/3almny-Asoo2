@extends('layout')
<title>3almny Asoo2 - Trainer Information</title>
@section('content')
    <!-- Hero Section with Banner -->
    <div class="container my-5 text-center">
        <div class="col-md-4 mx-auto">
            <img src="{{ asset('images/top.jpg') }}" alt="Experienced Trainers" class="icon mb-3 rounded" style="width: 100%; height: 300px; object-fit: cover;">
            <h5>Start Your Journey</h5>
        </div>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
    <form action="{{ route('account.storeTrainer') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Section: Personal Information -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('images/person.jpg') }}" alt="Personal Avatar" class="rounded-circle mr-3" width="60">
                    <h3>Personal Information</h3>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value="{{Auth::user()->name}}" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" value="{{Auth::user()->email}}" name="email" class="form-control" id="email" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone Number (work)</label>
                        <input type="text" name="phone" placeholder="Enter Your Phone Number " class="form-control" id="phone" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" id="city" name="city" class="form-control" placeholder="Search for a city" autocomplete="off">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" class="form-select" id="gender" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" placeholder="Enter Your Address in details" name="address" class="form-control" id="address" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label">Date of Birth</label>
                        <input type="date" placeholder="Enter Your Address in details" name="date_of_birth" class="form-control" id="address" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section: License Information -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('images/license.jpg') }}" alt="License Icon" class="rounded-circle mr-3" width="60">
                    <h3 class="mt-4">License Information</h3>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="national_id" class="form-label">National ID</label>
                        <input type="text" name="national_id" class="form-control" id="national_id" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="license_id" class="form-label">License ID</label>
                        <input type="text" name="license_id" class="form-control" id="license_id" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="license_end_date" class="form-label">License End Date</label>
                        <input type="date" name="license_end_date" class="form-control" id="license_end_date" required>
                        @error('license_end_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="license_front_image" class="form-label">Front License Image</label>
                        <input type="file" name="license_front_image" class="form-control" id="license_front_image" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="license_back_image" class="form-label">Back License Image</label>
                        <input type="file" name="license_back_image" class="form-control" id="license_back_image" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="national_id_front_image" class="form-label">Front National ID License Image</label>
                        <input type="file" name="national_id_front_image" class="form-control" id="national_id_front_image" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="national_id_back_image" class="form-label">Back National ID License Image</label>
                        <input type="file" name="national_id_back_image" class="form-control" id="national_id_back_image" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section: Car License Information (If has car) -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('images/car.jpg') }}" alt="Car License Icon" class="rounded-circle mr-3" width="60">
                    <h3>Car License Information</h3>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="has_car" class="form-label">Do you own a car?</label>
                        <select name="has_car" class="form-select" id="has_car" required>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div id="car-info-fields" class="col-md-6" style="display: none;">
                        <label for="car_license_image" class="form-label">Car License Image</label>
                        <input type="file" name="car_license_image" class="form-control" id="car_license_image">
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg">Save Information</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('has_car').addEventListener('change', function () {
        const carInfoFields = document.getElementById('car-info-fields');
        carInfoFields.style.display = this.value === '1' ? 'block' : 'none';
    });
</script>
@endsection
