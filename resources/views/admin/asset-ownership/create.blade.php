@extends('template.templateAdmin')

@section('title', $title)

@section('content')


<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Add Ownersip</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('asset-ownership') }}">Asset-Ownership</a></li>
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
                <form action="{{ route('asset-ownership.create') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">

                        {{-- <div class="form-group">
                            <label for="user">User<span class="text-danger">*</span></label>
                            <select class="form-select choices" id="user" name="user">
                                <option value="" selected disabled>Select User</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}" @if(old('user') == $user->id) selected @endif>{{ $user->full_name }}</option>
                                @endforeach
                            </select>
                            @error('user')
                            <small class="text-danger">{{ $message }}</small>
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

                    <div class="modal fade text-left modal-borderless" id="message" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Message</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <div class="row">
                                            <div class="col mb-2">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="message" id="message" rows="4" placeholder="Enter Message" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Send</button>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="text-end">
                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#message">Add</button>
                    </div>
                </div>
            </form>
            </div>
        </div>

@endsection
