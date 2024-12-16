@extends('template.templateAdmin')

@section('title', $title)

@section('content')


<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>User Account</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User Account</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="text-end m-3">
    <a href="{{ route('admin.user.create') }}" class="btn btn-primary">Create User</a>
</div>


    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    User Account Table
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Department</th>
                                <th>Reset Pass</th>
                                <th>Detail</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($readUser as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><a href="https://wa.me/{{ $user->phone }}" target="_blank">{{ $user->phone }}</a></td>
                                <td>{{ $user->department }}</td>
                                <td>
                                    <form action="{{ route('admin.reset-password', $user->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin reset password?')">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0" style="text-decoration: none">Reset Pass</button>
                                    </form>
                                </td>
                                <td></td>
                                <td class="d-flex">
                                    <a href="{{ route('admin.user.edit', $user->username) }}" class="btn text-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin User akan dihapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn text-danger"><i class="bi bi-trash3-fill"></i></button>
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
