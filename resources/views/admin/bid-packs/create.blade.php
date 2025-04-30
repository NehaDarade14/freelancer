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
                                        <h1>{{ __('Create Bid Pack') }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">{{ __('Create Bid Pack') }}</strong>
                            </div>
                            <div class="card-body">                                
                                <form method="POST" action="{{ route('admin.bid-packs.store') }}">
                                    @csrf

                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Bid Allowance</label>
                                                <input type="number" name="bids_allowed" class="form-control" min="1" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Price ($)</label>
                                                <input type="number" name="price" class="form-control" step="0.01" min="0" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Expiration Rules</label>
                                        <select name="expiration_rules" class="form-control" required>
                                            <option value="monthly">Monthly Reset</option>
                                            <option value="unlimited">Never Expire</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                                            <label class="form-check-label" for="is_active">
                                                Active Package
                                            </label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Create Bid Pack</button>
                                </form>
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
     
@include('admin.javascript')
    </body>

</html>