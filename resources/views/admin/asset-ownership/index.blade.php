@extends('template.templateAdmin')

@section('title', $title)

@section('content')


<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Asset-Ownership</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Asset-Ownership</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="text-end m-3">
    <a href="{{ route('asset-ownership.create') }}" class="btn btn-primary">Add Ownership</a>
</div>


    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Ownership Table
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Full Name</th>
                                <th>Department</th>
                                <th>Asset Name</th>
                                <th>Category</th>
                                <th>Code Asset</th>
                                <th>Sent Date</th>
                                <th>Status</th>
                                <th class="text-center">Details</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assetOwnership as $ownership)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ownership->user->full_name }}</td>
                                <td>{{ $ownership->user->department }}</td>
                                <td>{{ $ownership->asset->name }}</td>
                                <td>{{ $ownership->asset->category }}</td>
                                <td>{{ $ownership->asset->code_asset }}</td>
                                <td>{{ $ownership->asset->sent_date }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $ownership->asset->status }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('asset-ownership.detail',['name' => $ownership->user->username, 'item' => $ownership->asset->slug]) }}"><i class="bi bi-info-circle"></i></a>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('asset.edit.ownership', $ownership->asset->slug) }}"><i class="bi bi-pencil-square"></i></a>
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
