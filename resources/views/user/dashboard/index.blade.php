@extends('template.templateUser')

@section('title', $title)

@section('content')

<div class="page-title my-3">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Dashboard User</h3>
            <p class="text-subtitle text-muted">You Can See Request.</p>
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
    <section class="section">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Ini Dashboard</h4>
                    </div>
                    <div class="card-body">
                        <h3>...</h3>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
