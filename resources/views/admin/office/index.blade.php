@extends('template.templateAdmin')

@section('title', $title)

@section('content')


<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Office</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Office</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="text-end m-3">
    <a href="{{ route('office.create') }}" class="btn btn-primary">Create Office</a>
</div>


    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Office Table
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($readOffice as $office)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $office->name }}</td>
                                <td>{{ $office->category }}</td>
                                <td>{{ $office->address }}</td>
                                <td>{{ $office->status }}</td>
                                <td class="text-center">
                                    <a href="{{ route('office.edit', $office->slug) }}" class="btn text-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>

@endsection

@section('alert')
@if (session('success'))
<script>
  Toast.fire({
    icon: 'success',
    title: '{{ session("success") }}'
  })
</script>
@endif
@endsection
