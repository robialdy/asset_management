@extends('template.templateUser')

@section('title', $title)

@section('content')


<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Submission Recommendation</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Submission-Recommendation</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="text-end mb-3 me-3">
    <a href="{{ route('submission-recommendation.create') }}" class="btn btn-primary">Request</a>
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
                                <th>Department</th>
                                <th>Office</th>
                                <th>Purpose Of</th>
                                <th>Required Item</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th class="text-center">Status</th>
                                <th>Response</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recommendations as $recommendation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $recommendation->user->full_name }}</td>
                                <td>{{ $recommendation->user->department }}</td>
                                <td>{{ $recommendation->user->joinOffice->name }}</td>
                                <td>{{ $recommendation->purpose_of }}</td>
                                <td class="fw-bold">{{ $recommendation->required_item }}</td>
                                <td>{{ $recommendation->description }}</td>
                                <td class="text-nowrap">{{ $recommendation->created_at }}</td>
                                <td class="text-center">
                                    @if ($recommendation->status == 'Approved:Process')
                                        <span class="badge bg-primary">{{ $recommendation->status }}</span>
                                    @elseif ($recommendation->status == 'Under Review')
                                        <span class="badge bg-warning">{{ $recommendation->status }}</span>
                                    @elseif ($recommendation->status == 'Completed')
                                        <span class="badge bg-success">{{ $recommendation->status }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $recommendation->status }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($recommendation->status != 'Under Review')
                                        <button type="button" class="btn btn-link btn-viewReply" data-bs-toggle="modal" data-bs-target="#viewReply"
                                            data-id="{{ $recommendation->id }}">
                                            <i class="bi bi-reply fs-3 text-primary"></i>
                                        </button>
                                    @endif
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
		$(document).on('hidden.bs.modal', '#viewReply', function() {
			$(this).remove();
		});

		$(document).on('click', '.btn-viewReply', function() {
			var modalID = '#viewReply';

			// AJAX request
			$.ajax({
				url: "{{ route('submission-recommendation.modal') }}",
				type: 'POST',
				data: {
					id: $(this).data('id'),
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
