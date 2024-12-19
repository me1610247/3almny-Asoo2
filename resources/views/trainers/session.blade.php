@extends('layout')
<title>3almny Asoo2 - Create Sessions</title>
@section('content')
<div class="container mt-5">
    <h2>Create Session</h2>

    <form action="{{route('session.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="trainer_name" class="form-label">Trainer Name</label>
            <input type="text" class="form-control" id="trainer_name" value="{{ Auth::user()->name }}" disabled>
        </div>
        
        <div class="mb-3">
            <label for="course_id" class="form-label">Select Course</label>
            <select class="form-control" id="course_id" name="course_id" required>
                <option disabled selected value="">Select Course of Session</option>
                @foreach(Auth::user()->trainer->courses as $course)
                    <option value="{{ $course->id }}" data-price="{{ $course->price }}">
                        {{ $course->title }} - {{ $course->price }} LE
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="number_of_sessions" class="form-label">Number of Sessions</label>
            <input type="number" class="form-control" id="number_of_sessions" name="number_of_sessions" placeholder="Enter Number of Sessions" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price (per session)</label>
            <input type="text" class="form-control" id="price" name="price" value="0.00" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Create Session</button>
    </form>
</div>

<script>
    // Update the price field when course is selected
    document.getElementById('course_id').addEventListener('change', function () {
        var selectedOption = this.options[this.selectedIndex];
        var price = selectedOption.getAttribute('data-price');
        document.getElementById('price').value = price;
    });
</script>

@endsection
