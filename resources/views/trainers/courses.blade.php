@extends('layout')

@section('content')
<style>
    .line{
        height: 50px;
    }
</style>
<div class="container my-5">
    <h2 class="text-center mb-4">Approved Courses</h2>
    <div class="mb-3 mt-4">
        <a href="{{ route('courseTrainer.create') }}" class="btn btn-primary btn-lg">Add New Course</a>
    </div>
    @if($approvedCourses->isEmpty())
        <div class="alert alert-warning text-center">No approved courses yet.</div>
    @else
        <div class="row">
            @foreach($approvedCourses as $course)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-lg rounded-3 border-0">
                        <div class="card-body">
                            <h5 class="card-title line text-primary">{{ $course->title }}</h5>
                            <p class="card-text text-muted">{{ \Str::limit($course->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-0 text-dark font-weight-bold">Price: {{ $course->price }} LE</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

   
</div>
@endsection
