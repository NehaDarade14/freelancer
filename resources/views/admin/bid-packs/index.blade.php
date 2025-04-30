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
                                        <h1>{{ __('Manage Bid Packs') }}</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="page-header float-right">
                                    <div class="page-title">
                                        <ol class="breadcrumb text-right">
                                            <a href="{{ route('admin.bid-packs.create') }}" class="btn btn-primary">
                                                <i class="fa fa-plus"></i>{{ __('Add Bid Pack') }}
                                            </a>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">{{ __('Manage Bid Packs') }}</strong>
                            </div>
                            <div class="card-body">
                                <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Bids</th>
                                        <th>Price</th>
                                        <th>Expiration</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bidPacks as $pack)
                                    <tr>
                                        <td>{{ $pack->name }}</td>
                                        <td>{{ $pack->bids_allowed }}</td>
                                        <td>${{ number_format($pack->price, 2) }}</td>
                                        <td>{{ ucfirst($pack->expiration_rules) }}</td>
                                        <td>
                                            <span class="badge {{ $pack->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $pack->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.bid-packs.edit', $pack) }}" 
                                            class="btn btn-sm btn-outline-primary">Edit</a>
                                            <form action="{{ route('admin.bid-packs.destroy', $pack) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Delete this bid pack?')">
                                                    Delete
                                                </button>
                                            </form>
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
