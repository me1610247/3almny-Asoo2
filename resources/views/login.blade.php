@extends('layout')
<title>3almny Asoo2 - Login Page</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">

@section('content')
    <style>
        .login-text {
            font-family: 'Poppins', sans-serif;
            /* Custom font */
            font-size: 1.75rem;
            /* Adjust font size */
            font-weight: 600;
            /* Semi-bold */
            color: #333;
            /* Dark gray */
            letter-spacing: 1px;
            /* Adds a bit of spacing between letters */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            /* Optional shadow */
            transition: transform 0.3s ease;
            /* Smooth animation */
        }

        .login-text:hover {
            transform: scale(1.05);
            /* Slight zoom effect on hover */
            color: #007bff;
            /* Change color on hover */
        }

        .tagline {
            font-family: 'Poppins', sans-serif;
            /* Matches with the header font */
            font-size: 1rem;
            /* Slightly smaller for a professional tagline feel */
            font-weight: 300;
            /* Light weight to keep it subtle */
            color: #6c757d;
            /* Muted color */
            letter-spacing: 0.5px;
            /* Adds a bit of spacing between letters */
            line-height: 1.6;
            /* Increases readability */
            text-align: center;
            /* Centers text if not already */
            text-shadow: 0.5px 0.5px 1px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
            margin-bottom: 1.5rem;
            /* Adjust spacing if needed */
        }

        .logo-container {
            position: relative;
            display: inline-block;
        }

        .logo-img {
            width: 250px;
            height: 250px;
            object-fit: cover;
            border: 5px solid #007bff;
            /* Adds a bold border */
            padding: 10px;
            /* Space between image and border */
            border-radius: 50%;
            /* Ensures circular shape */
            box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.4),
                /* Darker shadow below */
                0px 4px 6px rgba(0, 0, 0, 0.2);
            /* Subtle soft shadow */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            /* Smooth hover effect */
        }

        /* Optional Hover Effect */
        .logo-img:hover {
            transform: scale(1.05);
            /* Slightly enlarges on hover */
            box-shadow: 0px 14px 20px rgba(0, 0, 0, 0.5),
                /* Stronger shadow on hover */
                0px 6px 8px rgba(0, 0, 0, 0.3);
            /* Softer shadow with more depth */
        }
    </style>
    <section class="p-3 p-md-4 p-xl-5">
        <div class="container">
            <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
                <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
                    <div class="card border-0 shadow-lg rounded-4" style="background-color: #ffffff;">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <h4 class="text-center fw-bold"
                                    style="
                            font-size: 2rem; 
                            font-family: 'Poppins', sans-serif; 
                            color: #2a3d4d; 
                            text-transform: uppercase; 
                            letter-spacing: 1.5px; 
                            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
                        ">
                                    Welcome to <span style="color: #ff6347;">3almny Asoo2</span>
                                </h4>
                                <p class="text-muted tagline">Connecting trainees with professional driving trainers</p>
                                <!-- Circular image with a larger size -->
                                <div class="logo-container text-center">
                                    <img src="{{ asset('images/logo.png') }}" alt="3almny Logo"
                                        class="rounded-circle logo-img">
                                </div>

                            </div>

                            <h5 class="text-center mt-3 mb-4 login-text">Login Here</h5>

                            @include('message')

                            <form method="POST" action="{{ route('account.authenticate') }}">
                                @csrf
                                <div class="form-floating mb-4">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" id="email" placeholder="name@example.com">
                                    <label for="email" class="form-label">Email</label>
                                    @error('email')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-floating mb-4">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="password" placeholder="Password">
                                    <label for="password" class="form-label">Password</label>
                                    @error('password')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="d-grid mb-4">
                                    <button class="btn btn-primary py-3 fw-bold" type="submit" style="border: none;">
                                        Log in now
                                    </button>
                                </div>
                            </form>

                            <div class="row">
                                <div class="col-12">
                                    <hr class="border-secondary-subtle">
                                    <div class="d-flex flex-column flex-md-row justify-content-center gap-2">
                                        <a href="{{ route('account.register') }}"
                                            class="link-primary text-decoration-none fw-semibold">
                                            Create new account
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
