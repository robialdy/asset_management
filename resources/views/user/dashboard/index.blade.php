@extends('template.templateUser')

@section('title', $title)

@section('content')

<div class="page-title my-3">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Dashboard User</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="row">
        <div class="col-12 col-lg-12">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldDocument"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Ur Asset</h6>
                                    <h6 class="font-extrabold mb-0">{{ $count['urAsset'] }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldLocation"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Ur Office Asset</h6>
                                    <h6 class="font-extrabold mb-0">{{ $count['urOffice'] }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3 ms-auto">
                    <div class="card">
                        <div class="card-body py-4 px-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xl">
                                    <img src="{{ asset('assets/static/images/logo/jne_profil.png') }}" alt="Face 1">
                                </div>
                                <div class="ms-3 name">
                                    <h5 class="font-bold">{{ Auth::user()->full_name }}</h5>
                                    <h6 class="text-muted mb-0">{{ Auth::user()->username }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($ownerships as $ownership)
                <div class="col-12 col-lg-3">
                    <div class="card mb-4 p-0">
                        <div class="card-body">
                            <!-- Gambar -->
                            <div class="d-flex align-items-center mb-4">
                                <img src="
                                 @if ($ownership->asset->category == 'Elektronik')
                                    {{ asset('assets/static/images/logo/petir.png') }}
                                @elseif ($ownership->asset->category == 'Furniture')
                                    {{ asset('assets/static/images/logo/meja.png') }}
                                @else
                                    {{ asset('assets/static/images/logo/fotocopi.png') }}
                                @endif
                                "
                                    alt="Asset Image"
                                    class="img-fluid me-4"
                                    style="width: 100px; border-radius: 10px;">
                                <div>
                                    <!-- Info Spesifik Asset -->
                                    <h5 class="mb-1">{{ $ownership->asset->name }}</h5>
                                    <p class="text-muted mb-0">{{ $ownership->asset->code_asset }}</p>
                                    <p class="text-muted mb-0">{{ $ownership->asset->category }}</p>
                                    <p class="text-muted mb-0">{{ $ownership->asset->sent_date }}</p>
                                    <p class="text-muted mb-0"> <span class="badge bg-primary">{{ $ownership->asset->status }}</span></p>
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
                @endforeach
            </div>
        </div>

</section>

@endsection
