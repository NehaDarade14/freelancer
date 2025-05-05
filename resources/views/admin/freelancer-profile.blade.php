<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    @include('admin.stylesheet')
</head>

<body>
    @include('admin.navigation')

    @if(Auth::user()->id == 1)
    <div id="right-panel" class="right-panel">
        @include('admin.header')
        @include('admin.warning')

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="breadcrumbs mb-3">
                            <div class="col-sm-4">
                                <div class="page-header float-left">
                                    <div class="page-title">
                                        <h1>{{ __('Create Bid Pack') }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    Freelancer Profile: {{ $edit['userdata']->name }}
                                </h6>
                                <div class="status-badges">
                                    <span class="badge badge-{{ $edit['userdata']->verified == 1 ? 'success' : 'danger' }}">
                                        {{ $edit['userdata']->verified == 1 ? 'Verified' : 'Unverified' }}
                                    </span>
                                    <span class="badge badge-{{ $edit['userdata']->kyc_status == 'approved' ? 'success' : ($edit['userdata']->kyc_status == 'rejected' ? 'danger' : 'warning') }}">
                                        KYC: {{ ucfirst($edit['userdata']->kyc_status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                                            <a class="nav-link active" id="personal-tab" data-toggle="pill" href="#personal">Personal Info</a>
                                            <a class="nav-link" id="kyc-tab" data-toggle="pill" href="#kyc">KYC Documents</a>
                                            <a class="nav-link" id="actions-tab" data-toggle="pill" href="#actions">Account Actions</a>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <!-- Personal Info Tab -->
                                            <div class="tab-pane fade show active" id="personal">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">

                                                    <tr>
                                                        <th>User</th>
                                                        <td> 
                                                            @if($edit['userdata']->user_photo != '')
                                                            <img class="lazy" width="100" height="100" src="{{ url('/') }}/public/storage/users/{{ $edit['userdata']->user_photo }}"  alt="{{ $edit['userdata']->name }}">
                                                            @else
                                                            <img class="lazy" width="100" height="100" src="{{ url('/') }}/public/img/no-image.png"  alt="{{ $edit['userdata']->name }}">
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Joined Date</th>
                                                        <td>{{ $edit['userdata']->created_at->format('d M Y') }}</td>
                                                    </tr>
                                                        
                                                    <tr>
                                                        <th>Name</th>
                                                        <td>{{ $edit['userdata']->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Email</th>
                                                        <td>{{ $edit['userdata']->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Professional Heading</th>
                                                        <td>{{ $edit['userdata']->professional_bio }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Skills</th>
                                                        <td>{{ $edit['userdata']->skills }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Experience</th>
                                                        <td>{{ $edit['userdata']->experience }}</td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>

                                            <!-- KYC Documents Tab -->
                                            <div class="tab-pane fade" id="kyc">
                                                @if($edit['userdata']->government_id || $edit['userdata']->biometric_photo || $edit['userdata']->signature_data || $edit['userdata']->address_proof)
                                                <div class="row">
                                                    <div class="col-md-12 mb-4">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    @php
                                                                        $fields = [
                                                                            'Government ID' => 'government_id',
                                                                            'Biometric Photo' => 'biometric_photo',
                                                                            'Signature Photo' => 'signature_data',
                                                                            'Address Proof' => 'address_proof'
                                                                        ];
                                                                    @endphp
                                                                    @foreach($fields as $label => $field)
                                                                    <div class="col-md-6 mb-4">
                                                                        <h5 class="card-title">{{ $label }}</h5>
                                                                        @if($edit['userdata']->$field)
                                                                            <img class="lazy" width="100" height="100" src="{{ url('/public/storage/users/'.$edit['userdata']->$field) }}" alt="{{ $edit['userdata']->name }}">
                                                                        @else
                                                                            <img class="lazy" width="50" height="50" src="{{ url('/public/img/no-image.png') }}" alt="{{ $edit['userdata']->name }}">
                                                                        @endif
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                                <div class="row">
                                                                    @if($edit['userdata']->kyc_status == 'pending')
                                                                    <div class="col-md-2 mb-4">
                                                                        <form action="{{ route('admin.kyc.approve', $edit['userdata']) }}" method="POST">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-success">Approve KYC</button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-md-2 mb-4">
                                                                        <form action="{{ route('admin.kyc.reject', $edit['userdata']) }}" method="POST">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-danger">Reject KYC</button>
                                                                        </form>
                                                                    </div>
                                                                    @else
                                                                    <div class="col-md-12">
                                                                        <span class="badge badge-{{ $edit['userdata']->kyc_status == 'approved' ? 'success' : 'danger' }}">
                                                                            {{ ucfirst($edit['userdata']->kyc_status) }}
                                                                        </span>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="alert alert-warning">No KYC documents submitted</div>
                                                @endif
                                            </div>

                                            <!-- Account Actions Tab -->
                                            <div class="tab-pane fade" id="actions">
                                                <div class="alert alert-danger">
                                                    <h5 class="alert-heading">Account Actions</h5>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#suspendModal">
                                                                {{ $edit['userdata']->account_status == 'suspended' ? 'Approve Account' : 'Suspend Account' }}
                                                            </button>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                                                                Permanently Remove Account
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- .tab-content -->
                                    </div> <!-- .col-md-8 -->
                                </div>
                            </div>
                        </div>
                    </div> <!-- col-md-12 -->
                </div> <!-- row -->
            </div> <!-- animated -->
        </div> <!-- content -->
    </div> <!-- right-panel -->

       <!-- Document Preview Modal -->
       <div class="modal fade" id="docPreviewModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Document Preview</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <iframe id="docPreviewFrame" style="width:100%; height:500px; border:none"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Suspension Modal -->
                        <div class="modal fade" id="suspendModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form method="POST" action="{{ $edit['userdata']->account_status == 'suspended' 
        ? route('admin.freelancer.approve', $edit['userdata']->id) 
        : route('admin.freelancer.suspend', $edit['userdata']->id) }}">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirm Suspension</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to {{ $edit['userdata']->account_status == 'suspended' ? 'approve' : 'suspend' }} this account?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-warning">Yes</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('admin.freelancer.remove', $edit['userdata']->id) }}">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirm Permanent Removal</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            This action cannot be undone. All associated data will be permanently deleted.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">Confirm Removal</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
    @else
        @include('admin.denied')
    @endif

    @include('admin.javascript')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // Document preview handling
    $('.preview-doc').click(function() {
        const url = $(this).data('url');
        const type = $(this).data('type');
        $('#docPreviewModal .modal-title').text(type);
        $('#docPreviewFrame').attr('src', url);
        $('#docPreviewModal').modal('show');
    });

    // Document approval/rejection
    $('.approve-doc, .reject-doc').click(function() {
        const status = $(this).hasClass('approve-doc') ? 'approved' : 'rejected';
        const docId = $(this).data('id');
        
        $.ajax({
            url: `/admin/kyc-documents/${docId}/status`,
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },
            success: function() {
                location.reload();
            }
        });
    });
});
</script>
</body>

</html>