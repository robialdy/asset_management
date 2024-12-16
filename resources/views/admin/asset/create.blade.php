@extends('template.templateAdmin')

@section('title', $title)

@section('content')


<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Create Asset</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="">Assets</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
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
            <form action="{{ route('admin.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name"> Asset Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="full-name" placeholder="Enter Name" name="name" value="">
                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="department">Category<span class="text-danger">*</span></label>
                            <select class="form-select" id="department" name="department">
                                <option selected disabled>Select Category</option>
                                <option value="ELEKTRONIK">ELEKTRONIK</option>
                                <option value="FURNITURE">FURNITURE</option>
                                <option value="PERALATAN"></option>
                            </select>
                            @error('department')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="code-asset">Code Asset<span class="text-danger">*</span> <small class="text-muted"><i>Generate Automatics!</i></small></label>
                            <input type="text" class="form-control" id="code-asset" name="code_asset" value="" readonly>
                            @error('full_name')
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
