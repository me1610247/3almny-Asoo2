<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
   <style>
body {
    background: linear-gradient(to right, #f5f7fa, #c3cfe2); /* Soft blue gradient */
    color: #333;
    font-family: 'Arial', sans-serif;
    background-image: url('https://www.transparenttextures.com/patterns/paper-fibers.png'); /* Subtle texture */
    background-size: cover;
    background-attachment: fixed;
}

        .navbar { background: linear-gradient(90deg, #2a3d4d, #374c5a); box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15); }
        .navbar-brand img { height: 45px; border-radius: 50%; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.2); }
        .navbar-nav .nav-link { color: #f8f9fa; font-weight: 500; transition: color 0.3s, transform 0.3s; }
        .navbar-nav .nav-link:hover { color: #e2e6ea; transform: scale(1.05); }
        .card { background-color: #fff; border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease; padding: 1.5rem; margin: 1rem 0; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2); }
        .card h5 { color: #2a3d4d; font-weight: bold; }
        .btn-primary { background-color: #2a3d4d; border: none; border-radius: 8px; padding: 8px 15px; transition: background-color 0.3s, box-shadow 0.3s; }
        .btn-primary:hover { background-color: #000; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); }
        .welcome-text {
    color: #ffffff;
    font-style: italic;         /* Italic font style */
    font-size: 1.25rem;         /* Font size to make it stand out */
    font-weight: 600;           /* Medium font weight for emphasis */
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3); /* Adds a soft shadow */
    transition: color 0.3s ease, text-shadow 0.3s ease; /* Smooth transition */
}

/* Optional Hover Effect */
.welcome-text:hover {
    color: #ffdd57; /* Soft yellow on hover */
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); /* Slightly bolder shadow */
}

  </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="3almny Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <span class="welcome-text">
                Welcome, {{ Auth::check() ? ucwords(Auth::user()->name) : 'Guest' }}
            </span>
             <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : (Auth::user()->role === 'trainer' ? (Auth::user()->trainer && Auth::user()->trainer->isInformationComplete() ? route('home.trainers') : route('homeTrainer')) : (Auth::user()->role === 'user' ? route('account.home') : route('home'))) }}">
                            Home
                        </a>
                    </li>
                    
                    @if (Auth::user()->role === 'trainer' && Auth::user()->trainer && Auth::user()->trainer->courses()->count() == 0)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('courseTrainer') }}">Courses</a>
                    </li>
                @endif
                
                    @if (Auth::user()->role === 'trainer' && Auth::user()->trainer && Auth::user()->trainer->courses()->where('approved', '1')->exists())
                    <li class="nav-item">
                            <a class="nav-link" href="{{ route('trainer.approvedCourses') }}">Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('session.show') }}">Sessions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('applications.show') }}">Applications</a>
                        </li>
                    @endif
                    @if (Auth::check() && Auth::user()->role =='user')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sessions.index') }}">Sessions</a>
                    </li>
                    @endif
                    @if (Auth::check() && \App\Models\Message::messageExists())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('messages.index') }}">Messages</a>
                    </li>
                @endif
                   
                    <li class="nav-item"><a class="nav-link" href="{{ route('account.profile') }}">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('account.logout') }}">Logout</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('account.login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('account.register') }}">Register</a></li>
                @endif
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')

    <script src="https://unpkg.com/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
