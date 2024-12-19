@extends('layout') <!-- Adjust this to your actual layout file -->

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

    <!-- Content -->
    <div class="container-fluid ms-3 mt-4">
        <h2 class="text-center mb-4">Registered Users</h2>
        <div class="table-responsive shadow p-3 mb-5 bg-body rounded">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-center">Details</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role === 'admin' ? 'Admin' : ucfirst($user->role) }}</td>
                            <td class="text-center">
                                <!-- View Details button with modals for Trainer/User -->
                                @if($user->role === 'trainer')
                                    <button class="btn btn-primary text-center" data-bs-toggle="modal" data-bs-target="#trainerDetailsModal-{{ $user->id }}">
                                        View Trainer Details
                                    </button>
                                    <!-- Trainer Details Modal -->
                                    <div class="modal fade" id="trainerDetailsModal-{{ $user->id }}" tabindex="-1" aria-labelledby="trainerDetailsLabel-{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="trainerDetailsLabel-{{ $user->id }}">Trainer Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Phone:</strong> {{ $user->trainer->phone ?? 'N/A' }}</p>
                                                    <p><strong>City:</strong> {{ $user->trainer->city ?? 'N/A' }}</p>
                                                    <p><strong>Address:</strong> {{ $user->trainer->address ?? 'N/A' }}</p>
                                                    <p><strong>Date of Birth:</strong> {{ $user->trainer->date_of_birth ?? 'N/A' }}</p>
                                                    <p><strong>National ID:</strong> {{ $user->trainer->national_id ?? 'N/A' }}</p>
                                                    <p><strong>License ID:</strong> {{ $user->trainer->license_id ?? 'N/A' }}</p>
                                                    <p><strong>License End Date:</strong> {{ $user->trainer->license_end_date ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($user->role === 'user')
                                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#userApplicationsModal-{{ $user->id }}">
                                        View User Applications
                                    </button>
                                    <!-- User Applications Modal -->
                                    <div class="modal fade" id="userApplicationsModal-{{ $user->id }}" tabindex="-1" aria-labelledby="userApplicationsLabel-{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="userApplicationsLabel-{{ $user->id }}">User Applications</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6>Applications:</h6>
                                                    <ul>
                                                        @foreach($user->applications as $application)
                                                            <li>{{ $application->name }} - {{ $application->status }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p>Not Applicable</p>
                                @endif
                            </td>

                            <!-- Actions Column -->
                            <td class="text-center">
                                <a href="" class="btn btn-secondary btn-sm">Edit</a>

                                <!-- Delete Button with Confirmation -->
                                <form action="" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
