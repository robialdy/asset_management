@extends('template.templateAdmin')

@section('title', $title)

@section('content')


<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Detail Office Ownership</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('asset-ownership') }}">Office-Ownership</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container py-5">

    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <img src="{{ asset('assets/static/images/logo/company.png') }}" alt="gambar"
              class="rounded-circle img-fluid" style="width: 150px;">
              <h5 class="mt-3">{{ $ownership->office->name }}</h5>
              <p class="text-muted">{{ $ownership->office->category }}</p>
          </div>
        </div>

<div class="card mb-4 p-0">
    <div class="card-body">
        <!-- Gambar -->
        <div class="d-flex align-items-center mb-4">
                <img src="{{ asset('assets/images/' . $ownership->asset->image) }}" alt="gambar"
                class="img-fluid me-3" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10%;">
            <div>
                <!-- Info Spesifik Asset -->
                <h5 class="mb-1">{{ $ownership->asset->name }}</h5>
                <p class="text-muted mb-0">{{ $ownership->asset->code_asset }}</p>
                <p class="text-muted mb-0">{{ $ownership->asset->category }}</p>
                <p class="text-muted mb-0">{{ $ownership->asset->sent_date }}</p>
            </div>
        </div>

        <hr>

        <!-- Detail Asset -->
        <h5 class="mb-4">Detail Asset</h5>
        @foreach ($ownership->asset->details as $detail)
        <div class="row">
            <div class="col-sm-4">
                <p class="mb-0">{{ $detail->title }}</p>
            </div>
            <div class="col-sm-8">
                <p class="text-muted mb-0">{{ $detail->description }}</p>
            </div>
        </div>
        <hr>
        @endforeach
    </div>
</div>


      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
              <h5 class="mb-4">Detail Office</h5>

            <div class="row">
              <div class="col-sm-4">
                <p class="mb-0">Name</p>
              </div>
              <div class="col-sm-8">
                <p class="text-muted mb-0">{{ $ownership->office->name }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-4">
                <p class="mb-0">Category</p>
              </div>
              <div class="col-sm-8">
                <p class="text-muted mb-0">{{ $ownership->office->category }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-4">
                <p class="mb-0">Address</p>
              </div>
              <div class="col-sm-8">
                <p class="text-muted mb-0">{{ $ownership->office->address }}</p>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>





@endsection
