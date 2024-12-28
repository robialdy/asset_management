<div class="modal fade" id="viewDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detail Recommendation / Request</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong>Applicant:</strong>
                    <p>{{ $detail->user->full_name }}</p>
                </div>
                <div class="mb-3">
                    <strong>Department:</strong>
                    <p>{{ $detail->user->department }}</p>
                </div>
                <div class="mb-3">
                    <strong>Office:</strong>
                    <p>{{ $detail->user->joinOffice->name }}</p>
                </div>
                <div class="mb-3">
                    <strong>Phone:</strong>
                    <p><a href="https://wa.me/{{ $detail->user->phone }}">{{ $detail->user->phone }}</a></p>
                </div>
                <div class="mb-3">
                    <strong>Category:</strong>
                    <p>{{ $detail->category }}</p>
                </div>
                <div class="mb-3">
                    <strong>Asset:</strong>
                    <p>
                        @if ($detail->id_asset)
                            {{ $detail->asset->name }}
                        @else
                            <span class="fst-italic">null</span>
                        @endif
                    </p>
                </div>
                <div class="mb-3">
                    <strong>Code Asset:</strong>
                    <p>
                        @if ($detail->id_asset)
                            {{ $detail->asset->code_asset }}
                        @else
                            <span class="fst-italic">null</span>
                        @endif
                    </p>
                </div>
                <div class="mb-3">
                    <strong>Admin:</strong>
                    <p>{{ $detail->admin->full_name }}</p>
                </div>
                <div class="mb-3">
                    <strong>Description:</strong>
                    <p>{{ $detail->description }}</p>
                </div>
                <div class="mb-3">
                    <strong>Request Date:</strong>
                    <p>{{ $detail->created_at }}</p>
                </div>
                <div class="mb-3">
                    <strong>Approved At:</strong>
                    <p>
                        @if ($detail->approved_at)
                            {{ $detail->approved_at }}
                        @else
                            <span class="fst-italic">null</span>
                        @endif
                    </p>
                </div>
                <div class="mb-3">
                    <strong>Completed At:</strong>
                    <p>{{ $detail->completed_at }}</p>
                </div>
                <div class="mb-3">
                    <strong>Status:</strong>
                    <p>
                        @if ($detail->status == 'Completed')
                            <span class="badge bg-success">{{ $detail->status }}</span>
                        @else
                            <span class="badge bg-danger">{{ $detail->status }}</span>
                        @endif
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>
