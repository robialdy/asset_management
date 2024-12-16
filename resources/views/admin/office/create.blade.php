@extends('template.templateAdmin')

@section('title', $title)

@section('content')


<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Create Office</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('office') }}">Office</a></li>
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
                <form action="{{ route('office.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Office Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Office Name" name="name" value="{{ old('name') }}">
                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category">Category<span class="text-danger">*</span></label>
                            <select class="form-select" id="category" name="category">
                                <option selected disabled>Select Category</option>
                                <option value="Kantor Pusat"  @if(old('category') == 'Kantor Pusat') selected @endif>Kantor Pusat</option>
                                <option value="Kantor Cabang" @if(old('category') == 'Kantor Cabang') selected @endif>Kantor Cabang</option>
                                <option value="Agen" @if(old('category') == 'Agen') selected @endif>Agen</option>
                                <option value="Gudang" @if(old('category') == 'Gudang') selected @endif>Gudang</option>
                                <option value="Drop Point" @if(old('category') == 'Drop Point') selected @endif>Drop Point</option>
                            </select>
                            @error('category')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status<span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status">
                                <option disabled selected>Select Status</option>
                                <option value="Active"  @if(old('status') == 'Active') selected @endif>Active</option>
                                <option value="Inactive"  @if(old('status') == 'Inactive') selected @endif>Inactive</option>
                            </select>
                            @error('status')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Address<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="address" id="address" rows="2">{{ old('address') }}</textarea>
                            @error('address')
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
