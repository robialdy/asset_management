@extends('template.templateUser')

@section('title', $title)

@section('content')


<div class="page-title mb-3">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Your Office Assets</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Your-Office-Assets</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Table
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Office Name</th>
                                <th>Name</th>
                                <th>Code Asset</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Sent Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ownerships as $ownership)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ownership->office->name }}</td>
                                <td class="fw-bold">{{ $ownership->asset->name }}</td>
                                <td>{{ $ownership->asset->code_asset }}</td>
                                <td>{{ $ownership->asset->category }}</td>
                                <td>{{ $ownership->asset->description }}</td>
                                <td>{{ $ownership->asset->sent_date }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>


@endsection
