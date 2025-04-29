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
                                    <h1>{{ __('KYC Submissions') }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">{{ __('KYC Submissions') }}</strong>
                        </div>
                        <div class="card-body">
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Submitted At</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($submissions as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($user->updated_at)->format('M d, Y H:i') }}</td>
                                        <td>
                                            @if( $user->kyc_status == "pending")
                                                <span class="badge bg-warning">{{ $user->kyc_status }}</span>
                                            @elseif($user->kyc_status == "approved")
                                                <span class="badge bg-success">{{$user->kyc_status}}</span>
                                            @else
                                                <span class="badge bg-danger">{{$user->kyc_status}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.kyc.show', $user->id) }}" class="btn btn-sm btn-primary">
                                                Review
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div>
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
<!-- Right Panel -->

<style>
.badge {
  color: white;
  padding:10px;
  text-transform: capitalize;
}
</style>
@include('admin.javascript')
<script type="text/javascript">
      $(document).ready(function () { 
    var oTable = $('#example').dataTable({
        stateSave: true
    });

    var allPages = oTable.fnGetNodes();

    $('body').on('click', '#selectAll', function () {
        if ($(this).hasClass('allChecked')) {
            $('input[type="checkbox"]', allPages).prop('checked', false);
        } else {
            $('input[type="checkbox"]', allPages).prop('checked', true);
        }
        $(this).toggleClass('allChecked');
    })
});
</script>
</body>

</html>