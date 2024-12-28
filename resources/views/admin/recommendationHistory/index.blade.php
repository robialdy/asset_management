@extends('template.templateAdmin')

@section('title', $title)

@section('content')


<div class="page-title mb-3">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Submission Request</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Submission-Request</li>
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
                                <th>applicant</th>
                                <th>Department</th>
                                <th>Phone</th>
                                <th>Asset</th>
                                <th>Code Asset</th>
                                <th>Request Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recommendations as $recommendation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $recommendation->user->full_name }}</td>
                                <td>{{ $recommendation->user->department }}</td>
                                <td><a href="https://wa.me/{{ $recommendation->user->phone }}">{{ $recommendation->user->phone }}</a></td>
                                <td class="fw-bold">
                                    @if ($recommendation->id_asset)
                                    {{ $recommendation->asset->name }}
                                    @else
                                    <span class="fst-italic">null</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($recommendation->id_asset)
                                    {{ $recommendation->asset->code_asset }}
                                    @else
                                    <span class="fst-italic">null</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">{{ $recommendation->created_at }}</td>
                                <td class="text-center">
                                    @if ($recommendation->status == 'Completed')
                                        <span class="badge bg-success">{{ $recommendation->status }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $recommendation->status }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                        <button type="button" class="btn btn-link btn-viewDetail" data-bs-toggle="modal" data-bs-target="#viewDetail"
                                            data-id="{{ $recommendation->id }}">
                                            <i class="bi bi-info-circle"></i>
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
		$(document).on('hidden.bs.modal', '#viewDetail', function() {
			$(this).remove();
		});

		$(document).on('click', '.btn-viewDetail', function() {
			var modalID = '#viewDetail';

			// AJAX request
			$.ajax({
				url: "{{ route('recommendation-history.modal') }}",
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
