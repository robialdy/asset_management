@extends('template.templateAdmin')

@section('title', $title)

@section('content')


<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Add Office-Ownership</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('office-ownership') }}">Office-Ownership</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
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
                <form action="{{ route('office-ownership.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">

                        {{-- <div class="form-group">
                            <label for="office">Office<span class="text-danger">*</span></label>
                            <select class="form-select choices" id="office" name="office">
                                <option value="" selected disabled>Select Office</option>
                                @foreach ($offices as $office)
                                <option value="{{ $office->id }}" @if(old('office') == $office->id) selected @endif>{{ $office->name }}</option>
                                @endforeach
                            </select>
                            @error('office')
                            <small class="text-danger m-0 p-0">{{ $message }}</small>
                            @enderror
                        </div> --}}

                        <div class="form-group">
                            <label for="request">Request<span class="text-danger">*</span></label>
                            <select class="form-select choices" id="request" name="request">
                                <optgroup label="Full Name - Required Item">
                                @foreach ($requests as $request)
                                <option value="{{ $request->id }}" @if(old('request') == $request->id) selected @endif>{{ $request->user->full_name }} - {{ $request->required_item }}</option>
                                @endforeach
                                </optgroup>
                            </select>
                            @error('request')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="asset">Asset<span class="text-danger">*</span></label>
                            <select class="form-select choices" id="asset" name="asset">
                                <option value="" disabled selected>Select Asset</option>
                                @foreach ($assets as $asset)
                                <option value="{{ $asset->id }}" @if(old('asset') == $asset->id) selected @endif>{{ $asset->name }}</option>
                                @endforeach
                            </select>
                            @error('asset')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary mt-2">Add</button>
                    </div>
                </div>
            </form>
            </div>
        </div>



@endsection
