@extends('template.templateAdmin')

@section('title', $title)

@section('content')

<div class="page-title mb-3">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Dashboard</h3>
            {{-- <p class="text-subtitle text-muted">You Can See Request.</p> --}}
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    {{-- <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li> --}}
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
    <section class="row">
        <div class="col-12 col-lg-9">
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
                                    <h6 class="text-muted font-semibold">Asset Ownership</h6>
                                    <h6 class="font-extrabold mb-0">{{ $count['assetOwnership'] }}</h6>
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
                                    <h6 class="text-muted font-semibold">Office Ownership</h6>
                                    <h6 class="font-extrabold mb-0">{{ $count['officeOwnership'] }}</h6>
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
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Available Assets</h6>
                                    <h6 class="font-extrabold mb-0">{{ $count['assets'] }}</h6>
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
                                    <div class="stats-icon red mb-2">
                                        <i class="iconly-boldNotification"></i>  <!-- Ikon untuk notifikasi masuk -->
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Incoming Request</h6>
                                    <h6 class="font-extrabold mb-0">{{ $count['request'] }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                Request Summary <script>document.write(new Date().getFullYear())</script>,
                                <span class="float-end">
                                    {{-- <a href="" class="text-end fs-6">Donwload Report</a> --}}
                                <button type="button" data-bs-toggle="modal" data-bs-target="#download"
                                        style="border: none; background-color: transparent; padding: 0;">
                                    <h4 class="fs-6">Download Report</h4>
                                </button>
                                </span>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
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
            <div class="card">
                <div class="card-header">
                    <h4>All Asset Ownership</h4>
                </div>
                <div class="card-body">
                    <div id="chart-visitors-profile"></div>
                </div>
            </div>
        </div>
    </section>

<div class="modal fade text-left modal-borderless" id="download" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Report Asset</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('asset.export') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <label for="reply_admin">Choose Category <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="category" id="employees" value="employees" required>
                                        <label class="form-check-label" for="employees">
                                            Employees
                                        </label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="category" id="office" value="office">
                                        <label class="form-check-label" for="office">
                                            Office
                                        </label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="category" id="available" value="available">
                                        <label class="form-check-label" for="available">
                                            Available
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="category" id="destroy" value="destroy">
                                        <label class="form-check-label" for="destroy">
                                            Destroy
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col">
                            <div class="form-group">
                                <label for="reply_admin">Choose Month <span class="text-danger">*</span></label>
                                <input type="month" class="form-control" id="" name="month" required>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>








    {{-- chart --}}
    <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    {{-- option --}}
    <script>
        let optionsVisitorsProfile = {
        series: [{{ $count['assetOwnership'] }}, {{ $count['officeOwnership'] }}, {{ $count['assets'] }}],
        labels: ["Employees", "Office", "Available"],
        colors: ["#ff0000", "#2c3e50", "#f39c12"],
        chart: {
            type: "donut",
            width: "100%",
            height: "350px",
        },
        legend: {
            position: "bottom",
        },
        plotOptions: {
            pie: {
            donut: {
                size: "30%",
            },
            },
        },
        }

        var chartVisitorsProfile = new ApexCharts(
        document.getElementById("chart-visitors-profile"),
        optionsVisitorsProfile
        )
        chartVisitorsProfile.render()

        // bulanan
        var optionsProfileVisit = {
        annotations: {
            position: "back",
        },
        dataLabels: {
            enabled: false,
        },
        chart: {
            type: "bar",
            height: 300,
        },
        fill: {
            opacity: 1,
        },
        plotOptions: {},
        series: [
            {
            name: "Request",
            data: @json($data),
            },
        ],
        colors: "#435ebe",
        xaxis: {
            categories: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
            ],
        },
        }
        var chartProfileVisit = new ApexCharts(
        document.querySelector("#chart-profile-visit"),
        optionsProfileVisit
        )
        chartProfileVisit.render()


    </script>

@endsection
