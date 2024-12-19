@extends('layout')

@section('content')
<div class="container mt-5">
    <div class="row">

        <!-- Course Creation Form -->
        <div class="col-md-8">
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            <h2>Create a New Course</h2>
            <h3>*Make Sure that course title will be useful and needed to attract trainees</h3>
            <form action="{{ route('courseTrainer.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Course Title</label>
                    <input type="text" placeholder="Enter The Title" class="form-control" id="title" name="title" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Course Description</label>
                    <textarea class="form-control" placeholder="Enter Description of The Course" id="description" name="description" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Course Price (Optional)</label>
                    <input type="number" class="form-control" placeholder="Price of The Course" id="price" name="price" step="0.01">
                </div>

                <button type="submit" class="btn btn-primary">Submit Course</button>
            </form>
        </div>
        <div class="col-md-4 d-flex justify-content-center align-items-center">
            <img src="{{asset('images/cor.jpeg')}}" alt="Trainer Avatar" class="card-img-top mx-auto"  style="width: 100%; height: 250px; object-fit: cover;">
        </div>
    </div>
</div>
@endsection
