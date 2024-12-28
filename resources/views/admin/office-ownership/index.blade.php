@extends('template.templateAdmin')

@section('title', $title)

@section('content')


<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Office-Ownership</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Office-Ownership</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="text-end m-3">
    <a href="{{ route('office-ownership.create') }}" class="btn btn-primary">Add Ownership</a>
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
                                <th>Office Name</th>
                                <th>C. Office</th>
                                <th>Asset Name</th>
                                <th>C. Asset</th>
                                <th>Code Asset</th>
                                <th>Sent Date</th>
                                <th>Status</th>
                                <th class="text-center">Details</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- prthitungan angka 2 loop --}}
                            @php
                                $number = 1;
                            @endphp
                             {{-- LOOP KHUSUS YANG STATUS SELAIN STATUS IN USE / REQUEST --}}
                            @foreach ($requestAsset as $request)
                            <tr>
                                <td>{{ $number }}</td>
                                <td>{{ $request->office->name }}</td>
                                <td>{{ $request->office->category }}</td>
                                <td>{{ $request->asset->name }}</td>
                                <td>{{ $request->asset->category }}</td>
                                <td>{{ $request->asset->code_asset }}</td>
                                <td>{{ $request->asset->sent_date }}</td>
                                <td>
                                    @if ($request->asset->status == 'Recommendation')
                                        <span class="badge bg-warning">
                                            {{ $request->asset->status }}
                                        </span>
                                    @elseif ($request->asset->status == 'Req:Destroy')
                                        <span class="badge bg-danger">
                                            {{ $request->asset->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('office-ownership.detail',['slugOffice' => $request->office->slug, 'slugAsset' => $request->asset->slug]) }}"><i class="bi bi-info-circle"></i></a>
                                </td>
                                <td class="d-flex">
                                    <a href="{{ route('office-ownership.edit', $request->asset->slug) }}" class="btn text-primary"><i class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('office-ownership.destroy', $request->asset->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn text-danger" onclick="confirm('Are you sure you are moving the asset to destroy?')"><i class="bi bi-send-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @php
                                $number++;
                            @endphp
                            @endforeach
                            @foreach ($officeOwnership as $ownership)
                            <tr>
                                <td>{{ $number }}</td>
                                <td>{{ $ownership->office->name }}</td>
                                <td>{{ $ownership->office->category }}</td>
                                <td>{{ $ownership->asset->name }}</td>
                                <td>{{ $ownership->asset->category }}</td>
                                <td>{{ $ownership->asset->code_asset }}</td>
                                <td>{{ $ownership->asset->sent_date }}</td>
                                <td>
                                        <span class="badge bg-primary">
                                            {{ $ownership->asset->status }}
                                        </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('office-ownership.detail',['slugOffice' => $ownership->office->slug, 'slugAsset' => $ownership->asset->slug]) }}"><i class="bi bi-info-circle"></i></a>
                                </td>
                                <td class="d-flex">
                                    <a href="{{ route('office-ownership.edit', $ownership->asset->slug) }}" class="btn text-primary"><i class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('office-ownership.destroy', $ownership->asset->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn text-danger" onclick="confirm('Are you sure you are moving the asset to destroy?')"><i class="bi bi-send-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @php
                                $number++;
                            @endphp
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
