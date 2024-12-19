@extends('layout')

@section('content')
<div class="container mt-5">
    <!-- Hero Section with Banner -->
    <div class="text-center bg-light p-5 rounded" style="background-image: url('path/to/hero-image.jpg'); background-size: cover;">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        @if(Auth::user()->role == 'trainer')
        @if(Auth::user()->trainer && Auth::user()->trainer->courses()->where('approved', '0')->exists())
            <div class="alert alert-warning">
                Your course is waiting for approval by the admin.
            </div>
        @endif
        
        @if(Auth::user()->trainer && Auth::user()->trainer->sessions()->where('status', 'pending')->exists())
            <div class="alert alert-warning">
                Your session is waiting for approval by the admin.
            </div>
        @endif
    @endif
        <h1 class="text-dark font-weight-bold">Become the Best Driving Instructor!</h1>
        <p class="lead text-dark">Empower the next generation of drivers—Start your sessions today.</p>
        @if(Auth::user()->role == 'trainer' && Auth::user()->trainer && Auth::user()->trainer->isInformationComplete())
        <a href="{{ route('account.sessions') }}" class="btn btn-primary btn-lg mt-3">Start Your Training Sessions</a>
    @else
        <a href="{{ route('homeTrainer') }}" class="btn btn-primary btn-lg mt-3">Complete Your Profile to Begin</a>
    @endif
    </div>

    <!-- Motivational Icons Section -->
    <section class="mt-5 text-center">
        <h2 class="mb-4">Why Start Training Now?</h2>
        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('images/driver.jpg') }}" style="width: 80%; height: 200px; object-fit: cover;" alt="Inspire New Drivers" class="icon mb-3 rounded" style="width: 100px;">
                <h5>Inspire the Next Generation</h5>
                <p>Help shape the future by training confident, skilled drivers.</p>
            </div>
            <div class="col-md-4">
                <img src="{{ asset('images/income.jpg') }}" style="width: 50%; height: 200px; object-fit: cover;" alt="Earn More Income" class="icon mb-3 rounded" style="width: 100px;">
                <h5>Boost Your Income</h5>
                <p>More sessions mean more opportunities to earn and grow your career.</p>
            </div>
            <div class="col-md-4">
                <img src="{{ asset('images/balance.jpg') }}" alt="Flexible Scheduling" style="width: 80%; height: 200px; object-fit: cover;" class="icon mb-3 rounded width:100%" style="width: 100px;">
                <h5>Flexible Hours</h5>
                <p>Set your own schedule and work when it suits you best.</p>
            </div>
        </div>
    </section>

    <!-- Trainer Success Section -->
    <section class="mt-5 text-center">
        <h2 class="mb-4">Become a Leading Trainer</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <img src="{{ asset('images/success.jpg') }}" class="card-img-top mx-auto" alt="Trainer Success" style="height: 200px; object-fit: cover; width: 100%; max-width: 100%; margin-bottom: 15px;">
                    <div class="card-body">
                        <h5 class="card-title">Impactful Training</h5>
                        <p class="card-text">Your experience and knowledge can change lives.</p>
                        <a href="{{route('account.sessions')}}" class="btn btn-outline-primary">Start Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <img src="{{ asset('images/expand.jpg') }}" class="card-img-top mx-auto" alt="Trainer Courses" style="height: 200px; object-fit: cover; width: 80%; max-width: 100%; margin-bottom: 15px;">
                    <div class="card-body">
                        <h5 class="card-title">Expand Your Courses</h5>
                        <p class="card-text">Offer a variety of driving courses to attract more trainees.</p>
                        <a href="{{route('courseTrainer')}}" class="btn btn-outline-primary">New Courses</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="mt-5 text-center bg-light p-5 rounded">
        <h2>What Other Trainers Say</h2>
        <div class="row mt-4">
            <div class="col-md-6">
                <blockquote class="blockquote">
                    <p>"Being a trainer with 3almny Asoo2 has given me the freedom to teach and earn at my own pace."</p>
                    <footer class="blockquote-footer">Trainer A</footer>
                </blockquote>
            </div>
            <div class="col-md-6">
                <blockquote class="blockquote">
                    <p>"The platform is easy to use, and the support team is fantastic."</p>
                    <footer class="blockquote-footer">Trainer B</footer>
                </blockquote>
            </div>
        </div>
    </section>
</div>
@endsection
