@extends('template.templateAdmin')

@section('title', $title)

@section('content')


<div class="page-title">
    <div class="row mb-3">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>List Destroy</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">List Destroy</li>
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
                                <th>Name</th>
                                <th>Code</th>
                                <th>Category</th>
                                <th>Destroy Date</th>
                                <th class="text-center">Detail</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($destroys as $destroy)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $destroy->name }}</td>
                                <td>{{ $destroy->code_asset }}</td>
                                <td>{{ $destroy->category }}</td>
                                <td>{{ $destroy->destroy_date }}</td>
                                <td class="text-center">
                                    <a href="{{ route('asset.destroy.detail', $destroy->slug) }}" class="text-primary">
                                        <i class="bi bi-info-circle"></i>
                                    </a>
                                </td>
                                <td class="text-center"><span class="badge bg-danger">{{ $destroy->status }}</span></td>
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

