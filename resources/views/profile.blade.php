<meta name="viewport" content="width=device-width, initial-scale=1">
<title>3almny Asoo2 - My Profile</title>
@extends('layout')
@section('content')
<style>
    .profile-heading {
    font-family: 'Poppins', sans-serif;  /* Use a modern font */
    font-size: 2rem;  /* Set font size */
    font-weight: 700;  /* Make it bold */
    color: #2a3d4d;  /* Set a primary color */
    letter-spacing: 1px;  /* Add some space between letters */
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);  /* Subtle text shadow for depth */
    margin-bottom: 20px;  /* Adjust margin for spacing */
}

</style>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <h4 class="text-center mb-4 profile-heading">My Profile</h4>
                    <form action="{{ route('account.updateProfile') }}" method="POST" id="userForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row gy-3">
                            <!-- Profile Picture Section -->
                            <div class="col-md-8 mx-auto text-center">                                
                                @if($user->profile_picture)
                                    <!-- Display User's Profile Picture -->
                                    <div class="profile-picture-container" style="position: relative; display: inline-block; text-align: center;">
                                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" id="profile_picture_preview" class="img-fluid rounded-circle mb-3" style="max-width: 150px; border: 3px solid #ddd; padding: 5px; cursor: pointer;">
                                        <input type="file" name="profile_picture" id="profile_picture" class="form-control" style="position: absolute; top: 0; left: 0; opacity: 0; width: 100%; height: 100%; cursor: pointer;" onchange="previewProfilePicture(event)">
                                    </div>
                                @else
                                    <!-- Display Initial or Default Avatar -->
                                    <div class="avatar text-center mb-3" style="width: 150px; height: 150px; border-radius: 50%; background-color: #6c757d; color: white; font-size: 3rem; display: flex; align-items: center; justify-content: center; cursor: pointer; margin: 0 auto;" onclick="document.getElementById('profile_picture').click();">
                                        <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                    <input type="file" name="profile_picture" id="profile_picture" class="form-control" style="display: none;" onchange="previewProfilePicture(event)">
                                @endif
                            </div>
                            <div class="col-md-8 mx-auto">
                                <label for="name" class="form-label">Name*</label>
                                <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control" value="{{ $user->name }}">
                            </div>
                            <div class="col-md-8 mx-auto">
                                <label for="email" class="form-label">Email*</label>
                                <input type="email" name="email" id="email" placeholder="Enter Email" class="form-control" value="{{ $user->email }}">
                            </div>
                            <div class="col-md-8 mx-auto">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" name="phone" id="phone" placeholder="Enter Your Phone Number" class="form-control" value="{{ $user->phone }}">
                            </div>
                            <div class="col-md-8 mx-auto">
                                <label for="role" class="form-label">Role</label>
                                <input type="text" readonly placeholder="Role" class="form-control" value="{{ ucwords($user->role) }}">
                                <p class="text-danger">Note: you can't change your role</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>

                <div class="card mt-4">
                    <h4 class="text-center mb-4">Change Password</h4>
                    <form action="{{ route('account.changePassword') }}" method="POST" id="changePasswordForm">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-md-8 mx-auto">
                                <label for="old_password" class="form-label">Current Password*</label>
                                <input type="password" name="old_password" placeholder="Enter Your Current Password" class="form-control" required>
                                @error('old_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-8 mx-auto">
                                <label for="new_password" class="form-label">New Password*</label>
                                <input type="password" name="new_password" placeholder="Enter Your New Password" class="form-control" required>
                                @error('new_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-8 mx-auto">
                                <label for="confirm_password" class="form-label">Confirm Password*</label>
                                <input type="password" name="new_password_confirmation" placeholder="Confirm Your Password" class="form-control" required>
                                @error('confirm_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preview selected profile picture
        function previewProfilePicture(event) {
            const preview = document.getElementById('profile_picture_preview');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function () {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
