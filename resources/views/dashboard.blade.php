@extends('layout')

@section('content')
<div class="d-flex mb-3">
    <!-- Sidebar -->
    <div class="bg-dark text-white p-3 sidebar fixed-sidebar" style="width: 250px;">
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
    <div class="flex-grow-1 p-4">
        <h2 class="text-center dashboard-heading mb-4">Admin Dashboard</h2>
        <p class="text-center description-text mb-4">Welcome to the Admin Dashboard! Here, you can find real-time insights and statistics about users, courses, and sessions on the platform.</p>

        <!-- Overview Section -->
        <div class="container mb-5">
            <h3 class="section-header mb-3">Platform Overview</h3>
            <p class="description-text mb-4">Below are the key performance indicators for the platform. These metrics provide an overview of the current gender distribution among trainers, monthly course and session activity, and user registration trends.</p>
        </div>

        <!-- Flex container for charts -->
        <div class="container mt-5">
            <div class="row">
                <!-- Gender Distribution Pie Chart -->
                <div class="col-lg-4 mb-4">
                    <div class="card p-3">
                        <h4 class="section-header mb-3">Gender Distribution</h4>
                        <p class="description-text mb-3">This chart shows the percentage of male and female trainers on the platform.</p>
                        <canvas id="genderChart" width="300" height="300"></canvas>
                    </div>
                </div>

                <!-- Course and Session Bar Chart -->
                <div class="col-lg-8 mb-4">
                    <div class="card p-3">
                        <h4 class="section-header mb-3">Monthly Courses and Sessions</h4>
                        <p class="description-text mb-3">The bar chart illustrates the number of courses and sessions added each month.</p>
                        <canvas id="courseSessionChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Cumulative User Registrations Line Chart -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card p-3">
                        <h4 class="section-header mb-3">New User Registrations</h4>
                        <p class="description-text mb-3">The line chart below shows the monthly trend of new user registrations, helping track platform growth over time.</p>
                        <canvas id="userRegistrationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Gender Distribution Pie Chart
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    const genderChart = new Chart(genderCtx, {
        type: 'pie',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                data: [{{ $maleCount }}, {{ $femaleCount }}],
                backgroundColor: ['#36a2eb', '#ff6384'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 14 } }
                }
            }
        }
    });

    // Bar Chart for Courses and Sessions
    const courseSessionCtx = document.getElementById('courseSessionChart').getContext('2d');
    const courseSessionChart = new Chart(courseSessionCtx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($courseCounts as $month => $count) 
                    "{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F') }}", 
                @endforeach
            ],
            datasets: [
                {
                    label: 'Courses',
                    data: [@foreach($courseCounts as $count) {{ $count }}, @endforeach],
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Sessions',
                    data: [@foreach($sessionCounts as $count) {{ $count }}, @endforeach],
                    backgroundColor: 'rgba(153, 102, 255, 0.7)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(200, 200, 200, 0.2)' }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: { font: { size: 14 } }
                }
            }
        }
    });

    // Line Chart for New User Registrations
    const userRegistrationCtx = document.getElementById('userRegistrationChart').getContext('2d');
    const userRegistrationChart = new Chart(userRegistrationCtx, {
        type: 'line',
        data: {
            labels: [
                @foreach($newUserCounts as $month => $count)
                    "{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F') }}",
                @endforeach
            ],
            datasets: [{
                label: 'New User Registrations',
                data: [@foreach($newUserCounts as $count) {{ $count }}, @endforeach],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.4 // Smooth line
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(200, 200, 200, 0.2)' }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: { font: { size: 14 } }
                }
            }
        }
    });
</script>

<style>
    /* General body font styling */
    body {
        font-family: 'Poppins', sans-serif;
        color: #333;
    }

    /* Sidebar */
    .sidebar h4 {
        font-size: 1.5rem;
        font-weight: bold;
        text-align: center;
    }

    .sidebar .nav-link {
        font-size: 1rem;
        font-weight: 500;
        padding: 10px 15px;
        color: #ffffff;
        transition: color 0.3s;
    }

    .sidebar .nav-link:hover {
        color: #ff6347; /* Adds a hover color */
    }

    /* Main Heading */
    .dashboard-heading {
        font-size: 2.5rem;
        font-weight: 700;
        color: #4e54c8;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    }

    /* Sub-headers for sections */
    .section-header {
        font-size: 1.75rem;
        font-weight: 600;
        color: #007bff;
        margin-bottom: 15px;
    }

    /* Descriptive text */
    .description-text {
        font-size: 1rem;
        font-weight: 400;
        color: #666;
        margin-bottom: 25px;
    }

    /* Cards for charts */
    .card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card p {
        color: #555;
    }
</style>

@endsection
