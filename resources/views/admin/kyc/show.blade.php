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
                <div class="col-md-3 ml-auto">
                
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
                            <strong class="card-title">KYC Review: {{ $user->name }}</strong>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h4>Government ID:</h4>
                                    @if($user->government_id != '')
                                        <img class="lazy img-fluid"  src="{{ url('/') }}/public/storage/users/{{ $user->government_id }}" alt="Government ID">
                                    @else
                                        <img class="lazy img-fluid"  src="{{ url('/') }}/public/img/no-image.png" alt="Government ID">
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h4>Biometric Photo:</h4>
                                    @if($user->biometric_photo != '')
                                        <img class="lazy img-fluid" src="{{ url('/') }}/public/storage/users/{{ $user->biometric_photo }}" alt="Biometric Photo">
                                    @else
                                        <img class="lazy img-fluid"  src="{{ url('/') }}/public/img/no-image.png" alt="Biometric Photo">
                                    @endif
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h4>Address Proof:</h4>
                                    @if($user->address_proof != '')
                                        <img class="lazy img-fluid"  src="{{ url('/') }}/public/storage/users/{{ $user->address_proof }}" alt="Address Proof">
                                    @else
                                        <img class="lazy img-fluid"  src="{{ url('/') }}/public/img/no-image.png" alt="Address Proof">
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h4>Signature Data:</h4>
                                    @if($user->signature_data != '')
                                        <img class="lazy img-fluid"  src="{{ url('/') }}/public/storage/users/{{ $user->signature_data }}" alt="Signature">
                                    @else
                                        <img class="lazy img-fluid"  src="{{ url('/') }}/public/img/no-image.png" alt="Signature">
                                    @endif
                                </div>
                            </div>
                            
                            <div class="d-flex gap-5">
                                <form action="{{ route('admin.kyc.approve', $user) }}" method="POST" class="mr-2">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Approve KYC</button>
                                </form>
                                
                                <form action="{{ route('admin.kyc.reject', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Reject KYC</button>
                                </form>
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
<style>
.gap-5 {
    float:right;
}

</style>

</body>

</html>
