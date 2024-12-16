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

<div class="text-end m-3">
    <a href="{{ route('asset.create ') }}" class="btn btn-primary">Create User</a>
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
                                <th>Detail</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Laptop Asus</td>
                                <td>#JNE/A/1161224</td>
                                <td>ELEKTRONIK</td>
                                <td>...</td>
                                <td></td>
                                <td class=""></td>
                            </tr>
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

