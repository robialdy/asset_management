@extends('template.templateAdmin')

@section('title', $title)

@section('content')


<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Available Assets</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Assets</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="text-end mb-3">
    <a href="{{ route('asset.create') }}" class="btn btn-primary">Create Asset</a>
</div>


    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Available Assets Table
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th class="text-center">Detail</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($readAssets as $asset)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $asset->name }}</td>
                                <td>{{ $asset->code_asset }}</td>
                                <td>{{ $asset->category }}</td>
                                <td>{{ $asset->description }}</td>
                                <td class="text-center">
                                    <a href="{{ route('asset.detail', $asset->slug) }}" class="text-primary">
                                        <i class="bi bi-info-circle"></i>
                                    </a>
                                </td>
                                <td class="d-flex justify-content-center">
                                    <a href="{{ route('asset.edit', $asset->slug) }}" class="btn text-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('asset.destroy.send', $asset->id) }}" method="POST" onsubmit="return confirm('Are you sure you are moving the asset to destroy?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn text-danger"><i class="bi bi-send-fill text-danger"></i></button>
                                    </form>
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

