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
            <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h4>Notifications</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Comment</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($notifs as $notif)
                                            @if (!is_null($notif->message))
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md">
                                                            <img src="{{ asset('assets/static/images/logo/jne_profil.png') }}">
                                                        </div>
                                                        <div class="ms-3">
                                                            @if ($notif->admin)
                                                                <p class="font-bold mb-0">{{ $notif->admin->full_name }}</p>
                                                            @endif
                                                            <p class="mb-0 text-muted">
                                                                {{ $notif->category }}
                                                                @if ($notif->asset)
                                                                    - {{ $notif->asset->name }}
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">{{ $notif->message }}</p>
                                                </td>
                                                <td>
                                                    {{ $notif->created_at }}
                                                </td>
                                            </tr>
                                            @endif

                                            @if (!is_null($notif->admin_reply))
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md">
                                                            <img src="{{ asset('assets/static/images/logo/jne_profil.png') }}">
                                                        </div>
                                                        <div class="ms-3">
                                                            @if ($notif->admin)
                                                                <p class="font-bold mb-0">{{ $notif->admin->full_name }}</p>
                                                            @endif
                                                            <p class="mb-0 text-muted">
                                                                {{ $notif->category }}
                                                                @if ($notif->asset)
                                                                    - {{ $notif->asset->name }}
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">{{ $notif->admin_reply }}</p>
                                                </td>
                                                <td>
                                                    {{ $notif->created_at }}
                                                </td>
                                            </tr>
                                            @endif
                                    @endforeach


                                    </tbody>
                                </table>
                                <div class="pagination pagination-sm">
                                    {{ $notifs->links() }}
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
                                <img src="{{ asset('assets/images/' . $ownership->asset->image) }}" alt="gambar"
                                class="img-fluid me-3" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10%;">
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
