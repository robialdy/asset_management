@extends('template.templateUser')

@section('title', $title)

@section('content')


<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Submission Request</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('submission-recommendation') }}">Submission-Request</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Request</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card">
            <div class="card-header">
                <h4 class="card-title">Form</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('submission-recommendation.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="full_name">Full Name<span class="text-danger">*</span> <small class="text-muted"><i>Your Full Name!</i></small></label>
                            <input type="text" class="form-control" id="full_name" name="full_name" value="{{ Auth::user()->full_name }}" disabled>
                            @error('full_name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="required_item">Required Item<span class="text-danger">*</span> <small class="text-muted"><i>explain why & what the need is</i></small></label>
                            <input type="text" class="form-control" id="required_item" name="required_item" value="{{ old('required_item') }}" placeholder="Enter Required Item">
                            @error('required_item')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">Reason<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" id="description" rows="4" placeholder="Please enter the reasons and approximate specifications required">{{ old('description') }}</textarea>
                            @error('description')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary mt-2">Create</button>
                    </div>
                </div>
            </form>
            </div>
        </div>



@endsection
