@extends('layout')
<title>3almny Asoo2 - Register</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">

@section('content')
<style>
    /* General Styling */
    .login-text {
        font-family: 'Poppins', sans-serif;
        font-size: 1.75rem;
        font-weight: 600;
        color: #333;
        letter-spacing: 1px;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .login-text:hover {
        transform: scale(1.05);
        color: #007bff;
    }

    .tagline {
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        font-weight: 300;
        color: #6c757d;
        letter-spacing: 0.5px;
        line-height: 1.6;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    /* Logo Styling */
    .logo-container {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .logo-img {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border: 5px solid #007bff;
        padding: 10px;
        border-radius: 50%;
        box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.4), 0px 4px 6px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .logo-img:hover {
        transform: scale(1.05);
        box-shadow: 0px 14px 20px rgba(0, 0, 0, 0.5), 0px 6px 8px rgba(0, 0, 0, 0.3);
    }
</style>

<section class="p-3 p-md-4 p-xl-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
                <div class="card border border-light-subtle rounded-4">
                    <div class="card-body p-4">
                        <h4 class="text-center fw-bold" style="
                            font-size: 2rem; 
                            font-family: 'Poppins', sans-serif; 
                            color: #4e54c8; 
                            text-transform: uppercase; 
                            letter-spacing: 1.5px; 
                            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
                        ">
                            Welcome to <span style="color: #ff6347;">3almny Asoo2</span>
                        </h4>
                        <p class="tagline">Connecting trainees with professional driving trainers</p>

                        <div class="logo-container">
                            <img src="{{ asset('images/logo.png') }}" alt="3almny Logo" class="logo-img">
                        </div>

                        <h5 class="text-center mt-3 mb-4 login-text">Register as Trainer</h5>
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('account.processTrainerRegister') }}">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" value="{{ old('name') }}" required>
                                        <label for="name" class="form-label">Name</label>
                                        @error('name')
                                            <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                                        <label for="email" class="form-label">Email</label>
                                        @error('email')
                                            <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password" required>
                                        <label for="password" class="form-label">Password</label>
                                        @error('password')
                                            <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="confirm_password" placeholder="Confirm Password" required>
                                        <label for="confirm_password" class="form-label">Confirm Password</label>
                                        @error('password_confirmation')
                                            <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn btn-primary py-3" type="submit">Register Now</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row mt-4">
                            <div class="col-12">
                                <hr class="border-secondary-subtle">
                                <div class="d-flex gap-2 flex-column flex-md-row justify-content-center">
                                    <a href="{{ route('account.login') }}" class="link-secondary text-decoration-none">Already have an account? Login here</a>
                                </div>
                                <hr>
                                <div class="d-flex gap-2 flex-column flex-md-row justify-content-center">
                                    <a href="{{ route('register-trainer') }}" class="link-secondary text-decoration-none">Sign Up as a Trainer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
@endsection
