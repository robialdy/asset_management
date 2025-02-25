@extends('template.templateAdmin')

@section('title', $title)

@section('content')


<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Information Asset {{ $dataAsset->name }}</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('assets') }}">Assets</a></li>
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
                <img src="{{ asset('assets/images/' . $dataAsset->image) }}" alt="gambar"
         class="img-fluid" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
              <p class="text-muted mt-2">{{ $dataAsset->category }}</p>
            <h5 class="my-3">{{ $dataAsset->name }}</h5>
          </div>
        </div>
        <div class="card mb-4 p-0">
          <div class="card-body">
            <h5 class="mb-4">Detail Asset</h5>
            @foreach ($dataDetailAsset as $dasset)
            <div class="row">
              <div class="col-sm-4">
                <p class="mb-0">{{ $dasset->title }}</p>
              </div>
              <div class="col-sm-8">
                <p class="text-muted mb-0">{{ $dasset->description }}</p>
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
              <h5 class="mb-4">Asset</h5>

            <div class="row">
              <div class="col-sm-4">
                <p class="mb-0">Name</p>
              </div>
              <div class="col-sm-8">
                <p class="text-muted mb-0">{{ $dataAsset->name }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-4">
                <p class="mb-0">Code Asset</p>
              </div>
              <div class="col-sm-8">
                <p class="text-muted mb-0">{{ $dataAsset->code_asset }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-4">
                <p class="mb-0">Category</p>
              </div>
              <div class="col-sm-8">
                <p class="text-muted mb-0">{{ $dataAsset->category}}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-4">
                <p class="mb-0">Added Date</p>
              </div>
              <div class="col-sm-8">
                <p class="text-muted mb-0">{{ $dataAsset->added_date }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-4">
                <p class="mb-0">Description</p>
              </div>
              <div class="col-sm-8">
                <p class="text-muted mb-0">{{ $dataAsset->description }}</p>
              </div>
            </div>

            @if (request()->is('admin/asset/destroy/detail*'))
            <hr>
            <div class="row">
              <div class="col-sm-4">
                <p class="mb-0">Destroy Date</p>
              </div>
              <div class="col-sm-8">
                <p class="text-muted mb-0">{{ $dataAsset->destroy_date }}</p>
              </div>
            </div>
            @endif

          </div>
        </div>

      </div>
    </div>
  </div>

@endsection
