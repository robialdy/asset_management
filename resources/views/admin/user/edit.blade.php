@extends('template.templateAdmin')

@section('title', $title)

@section('content')


<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Edit Create</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.view') }}">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                <form action="{{ route('admin.user.update', $user->username) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="full-name">Full Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="full-name" placeholder="Enter Full" name="full_name" value="{{ old('full_name', $user->full_name) }}">
                            @error('full_name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email<span class="text-danger">*</span> <small class="text-muted"><i>jneid@example.com</i></small></label>
                            <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" value="{{ old('email', $user->email) }}">
                            @error('email')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone<span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="phone" placeholder="Enter Phone Number" name="phone" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">Username<span class="text-danger">*</span></label>
                            <input type="username" class="form-control" id="username" placeholder="Enter Username" name="username" value="{{ old('username', $user->username) }}"">
                            @error('username')
                            <small class="text-danger">{{ $message }}></small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="department">Department<span class="text-danger">*</span></label>
                            <select class="form-select" id="department" name="department">
                                <option selected disabled>Select Department</option>
                                <option value="IT" @if(old('department', $user->department) == 'IT') selected @endif>IT</option>
                                <option value="Finance" @if(old('department', $user->department) == 'Finance') selected @endif>Finance</option>
                                <option value="HR" @if(old('department', $user->department) == 'HR') selected @endif>HR</option>
                            </select>
                            @error('department')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="id_office">Office<span class="text-danger">*</span></label>
                            <select class="form-select choices" id="id_office" name="id_office">
                                <option selected disabled>Select Office</option>
                                @foreach ($offices as $office)
                                <option value="{{ $office->id }}" @if(old('id_office', $user->id_office) == $office->id) selected @endif>{{ $office->name }}</option>
                                @endforeach
                            </select>
                            @error('id_office')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary mt-2">Edit</button>
                    </div>
                </div>
            </form>
            </div>
        </div>



@endsection