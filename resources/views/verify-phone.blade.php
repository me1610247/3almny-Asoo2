<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Phone Number</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<style>
    /* Same styles as in your profile page */
    body { background: linear-gradient(135deg, #70a372 0%, #fff 100%); color: #333; margin: 0; font-family: 'Arial', sans-serif; }
    .card { background-color: #EAF4E1; border: none; box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2); animation: fade-in 0.6s ease-in-out; border-radius: 15px; padding: 2rem; }
    .btn-primary { background-color: #4CAF50; border: none; color: #FFFFFF; font-weight: bold; border-radius: 25px; padding: 12px 25px; font-size: 14px; width: auto; transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
    .btn-primary:hover { background-color: #45A049; transform: scale(1.05); box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15); }
    .form-control { border-color: #4CAF50; border-radius: 10px; padding: 10px; transition: border-color 0.3s ease, box-shadow 0.3s ease; }
    .form-label { color: #000; font-weight: bold; }
    .form-control:focus { border-color: #45A049; box-shadow: 0 0 5px rgba(69, 160, 73, 0.3); }
    .navbar { background-color: #4CAF50; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-bottom: 2px solid #EAF4E1; }
    .navbar-brand img { height: 40px; border-radius: 5px; box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.2); animation: pulse 1s ease-in-out infinite; }
    .navbar-nav .nav-link { color: #FFFFFF; font-weight: bold; transition: color 0.3s ease; }
    .navbar-nav .nav-link:hover { color: #EAF4E1; }
    @keyframes fade-in { 0% { opacity: 0; transform: translateY(-20px); } 100% { opacity: 1; transform: translateY(0); } }
    @media (max-width: 768px) { .col-md-8 { max-width: 100%; } }
</style>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="{{ asset('images/logo.png') }}" alt="3almny Logo"></a>
            <span class="text-white font-style:italic">Welcome, {{ ucwords(Auth::user()->name) }}</span>
        </div>
    </nav>
    <div class="container py-5">
        <h4 class="text-center mb-4">Verify Your Phone Number</h4>

        <!-- Error message for invalid verification code -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form to enter the verification code -->
        <form action="{{ route('profile.verifyPhone') }}" method="POST" class="mt-4">
            @csrf
            <div class="row gy-3">
                <div class="col-md-6 mx-auto mb-5">
                    <label for="phone_verify_code" class="form-label">Verification Code</label>
                    <input type="text" name="phone_verify_code" id="phone_verify_code" placeholder="Enter Verification Code" class="form-control" required>
                </div>
            </div>

            <div class="d-flex justify-content-center mb-3">
                <button type="submit" class="btn btn-primary mx-4">Verify Phone Number</button>
                <a href="{{ route('account.profile') }}" class="btn btn-primary">Back to Profile</a>
            </div>
        </form>
    </div>

    <script src="https://unpkg.com/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
