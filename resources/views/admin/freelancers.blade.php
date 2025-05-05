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

    <!-- Right Panel -->
    @if(Auth::user()->id == 1)
    <div id="right-panel" class="right-panel">
        @include('admin.header')
        @include('admin.warning')
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-3 ml-auto" align="right">
                    </div>
                    <div class="col-md-12">
                        <div class="breadcrumbs">
                            <div class="col-sm-4">
                                <div class="page-header float-left">
                                    <div class="page-title">
                                        <h1>{{ __('Freelancer List') }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Freelancers List</h6>
                            <div class="float-right">
                                <select id="kycFilter" class="form-control-sm">
                                    <option value="">All KYC Statuses</option>
                                    @foreach($kycStatuses as $status)
                                        <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>KYC Status</th>
                                            <th>Joined</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($itemData['item'] as $freelancer)
                                        <tr>
                                            <td>{{ $freelancer->id }}</td>
                                            <td>{{ $freelancer->name }}</td>
                                            <td>{{ $freelancer->email }}</td>
                                            <td>
                                                <span class="badge badge-{{ $freelancer->kyc_status == 'approved' ? 'success' : ($edit['userdata']->kyc_status == 'rejected' ? 'danger' : 'warning')}}">
                                                    {{ ucfirst($freelancer->kyc_status) }}
                                                </span>
                                            </td>
                                            
                                            <td> {{ \Carbon\Carbon::parse($freelancer->created_at)->format('M d, Y H:i') }}
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.freelancer.profile', $freelancer->user_id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $freelancer->user_id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
        @include('admin.denied')
    @endif   
<!-- Suspension Modal -->
<div class="modal fade" id="suspendModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="suspendForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Suspend Freelancer</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Reason for Suspension</label>
                        <textarea name="reason" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Confirm Suspension</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('admin.javascript')
   
<script>
$(document).ready(function() {
    // KYC status filtering
    $('#kycFilter').change(function() {
        window.location.href = "{{ route('admin.freelancers') }}?kyc_status=" + $(this).val();
    });

    // Suspension handling
    $('.suspend-btn').click(function() {
        var id = $(this).data('id');
        $('#suspendForm').attr('action', '/admin/freelancers/' + id + '/suspend');
        $('#suspendModal').modal('show');
    });

    // Delete handling
    $('.delete-btn').click(function() {
        if(confirm('Permanently remove this freelancer?')) {
            window.location.href = '/admin/freelancers/' + $(this).data('id') + '/remove';
        }
    });
});
</script>
</body>

</html>