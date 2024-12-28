@extends('template.templateAdmin')

@section('title', $title)

@section('content')


<div class="page-title mb-3">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Destroy Request</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Destroy-Request</li>
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
                                <th>Department</th>
                                <th>Office</th>
                                <th>Phone</th>
                                <th>Asset</th>
                                <th>Code Asset</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $request)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $request->user->full_name }}</td>
                                <td>{{ $request->user->department }}</td>
                                <td>{{ $request->user->joinOffice->name }}</td>
                                <td><a href="https://wa.me/{{ $request->user->phone }}">{{ $request->user->phone }}</a></td>
                                <td class="fw-bold">{{ $request->asset->name }}</td>
                                <td>{{ $request->asset->code_asset }}</td>
                                <td>{{ $request->description }}</td>
                                <td class="text-nowrap">{{ $request->created_at }}</td>
                                <td class="text-center">
                                    @if ($request->status == 'Approved:Process')
                                        <span class="badge bg-primary">{{ $request->status }}</span>
                                    @elseif ($request->status == 'Under Review')
                                        <span class="badge bg-warning">{{ $request->status }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-link btn-reply" data-bs-toggle="modal" data-bs-target="#reply"
                                        data-id="{{ $request->id }}" {{ $request->status == 'Approved:Process' ? 'disabled' : '' }}>
                                        <i class="bi bi-send-fill text-primary fs-5"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

<div id="modal-container">
    {{-- konten modal di tampilkan --}}
</div>

    {{-- JQUERY --}}
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>

    <script>
    $(document).ready(function() {
		$(document).on('hidden.bs.modal', '#reply', function() {
			$(this).remove();
		});

		$(document).on('click', '.btn-reply', function() {
			var modalID = '#reply';

			// AJAX request
			$.ajax({
				url: "{{ route('destroy-request.modal') }}",
				type: 'POST',
				data: {
					id: $(this).data('id'), //id recommendation
                    _token: '{{ csrf_token() }}',
				},
				dataType: "json",
				success: function(response) {
                    // di load
					$('#modal-container').html(response.html);
                    // di tampilkan
					$(modalID).modal('show');
				},
			});
		});
	});
    </script>


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
